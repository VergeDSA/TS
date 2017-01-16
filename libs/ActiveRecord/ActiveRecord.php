<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 16.12.16
 * Time: 11:24
 */

namespace Libs\ActiveRecord;

use Libs\Framework\Db;
use Libs\Traits;

class ActiveRecord
{
    use Traits\MagicSet, Traits\MagicGet, Traits\MagicIsSet;
    use Traits\GetTableProperties, Traits\SetTableProperties;

    protected static $class_name = 'stdClass';
    protected static $table_fields = ['*'];
    protected $data = [];

    
    public function __construct()
    {
        static::$class_name = get_called_class();
    }

    protected static function query(string $query, array $columns = [])
    {
        $ph_columns = [];
        if (!empty($columns)) {
            foreach ($columns as $key => $value) {
                $ph_columns[':' . $key] = $value;
            }
        }
        echo $query,'<br />';
        $result = Db::getDbConnection()->prepare($query);
        $result->execute($ph_columns);
        return $result;
    }

    public static function fetchAll($deleted = 'ACTIVE', $joins = [])
    {
        $query = self::buildQuery($stn = static::$table_name, $stf = static::$table_fields, $deleted, $joins);
        $query['query_start'] .= ' FROM ' . $stn;
//        echo implode('', $query);
//        die;
        $result = self::query(implode('', $query));
        return $result->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function fetchById(int $id, $deleted = 'ACTIVE', $joins = [])
    {
        $query = self::buildQuery($stn = static::$table_name, $stf = static::$table_fields, $deleted, $joins);
        $query['query_start'] .= ' FROM ' . $stn;
        $query['query_end'] .= ' AND ' . $stn . '.id=:id';
        echo implode('', $query); die;
        $result = self::query(implode('', $query), ['id' => $id]);
        $result = $result->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return (count($result)>1) ? $result : $result[0] ;
    }

    protected static function buildQuery($stn, $stf, $deleted, $joins)
    {
        if (is_array($stf)) {
            $query = 'SELECT ' . $stn . '.' . implode(',' . $stn . '.', $stf);
        };
        if (is_string($stf)) {
            $query = 'SELECT ' . $stf;
        };
        $query_middle = '';
        $query_end = '';
        if ('DELETED' == $deleted) {
            $query_end .= ' WHERE ' . $stn . '.deleted=1';
        } elseif ('ACTIVE' == $deleted) {
            $query_end .= ' WHERE ' . $stn . '.deleted=0';
        }
        if (!empty($joins)) {
            foreach ($joins as $join_obj => $join_params) {
                $join_class = MODELS_FOLDER . $join_obj;
                $join_table = $join_class::getTableName();
                $join_fields = $join_class::getTableFields();
                array_walk($join_fields, function (&$item, $key, $join_table) {
                    $item = $item . ' AS \'' . $join_table . '.' . $item . '\'';
                }, $join_table);
                $query .= ',' . $join_table . '.' . implode(',' . $join_table . '.', $join_fields);
//                $query .= ' as ' . $join_table . '.*';
                list($join_method, $join_condition_left, $join_condition_right, $join_condition_add) =
                    array_pad(explode('/', $join_params, 4), 4, null);
                $query_middle .= ' ' . strtoupper($join_method) . ' JOIN ' . $join_table . ' ON';
                $query_middle .= ' ' . $join_condition_left . '=' . $join_condition_right;
                if ('DELETED' == $deleted) {
                    $query_end .= ' AND ' . $join_table . '.deleted=1';
                } elseif ('ACTIVE' == $deleted) {
                    $query_end .= ' AND ' . $join_table . '.deleted=0';
                }
                !$join_condition_add ?: $query_end .= ' AND ' . $join_table . '.' . $join_condition_add;

            }
        }
        return array(
            'query_start' => $query,
            'query_middle' => $query_middle,
            'query_end' => $query_end);
    }

    private function insert()
    {
        $query = 'INSERT INTO '. static::$table_name
            .' (' . implode(',', array_keys($this->data)) . ')'
         .' VALUES (:' . implode(',:', array_keys($this->data)) . ')';
        return self::query($query, $this->data);
    }

    private function update()
    {
        $query = 'UPDATE '. static::$table_name . ' SET ';
        foreach (array_keys($this->data) as $key) {
            if ('id'==$key) {
                continue;
            }
            $query .=  $key .'=:'.$key.',';
        }
        $query = substr($query, 0, -1);
        $query .= ' WHERE id=:id';
        return self::query($query, $this->data);
    }

    public function save()
    {
        if (!isset($this->id)) {
            $this->insert();
            $this->id = Db::getDbConnection()->lastInsertId();
        } else {
            $this->update();
        }
    }

    public function delete()
    {
        $query = 'UPDATE '. static::$table_name . ' SET ' .
            'deleted=1';
        $query .= ' WHERE id=:id';
        return self::query($query, $this->data);
    }

    public function unDelete()
    {
        $query = 'UPDATE '. static::$table_name . ' SET ' .
            'deleted=0';
        $query .= ' WHERE id=:id';
        return self::query($query, $this->data);
    }
    public static function count($params, $type = 'COUNT(*) as count', $deleted = 'ACTIVE', $joins = [])
    {
        $query_params = '';
        $query = self::buildQuery($stn = static::$table_name, $type, $deleted, $joins);
        $query['query_start'] .= ' FROM ' . $stn;
        foreach (array_keys($params) as $key) {
            $query_params .= ' AND ' . $key .'=:'.$key;
        }
        $query['query_end'] = $query['query_end'].$query_params;
//        echo implode('', $query); die;
        $result = self::query(implode('', $query), $params);
        return $result->fetchAll()[0]['count'];
    }
    public static function fetchByParams($params, $deleted = 'ACTIVE', $joins = [], $end_condition = '')
    {
        $query_params = '';
        $query = self::buildQuery($stn = static::$table_name, $stf = static::$table_fields, $deleted, $joins);
        $query['query_start'] .= ' FROM ' . $stn;
        foreach (array_keys($params) as $key) {
            $query_params .= ' AND ' . $stn . '.' . $key .'=:'.$key;
        }
        $query['query_end'] = $query['query_end'].$query_params.$end_condition;

        $result = self::query(implode('', $query), $params);
        $result = $result->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return (count($result)>1) ? $result : $result[0] ;
    }
}
