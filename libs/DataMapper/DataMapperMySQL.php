<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 16.12.16
 * Time: 11:24
 */

namespace Libs\DataMapper;

class DataMapperMySQL
{
    protected static $class_name = 'stdClass';
    private static $params = array();
    private static $db = false;

    public function __construct($db)
    {
        self::$db = $db;
    }

    protected static function query(string $query, array $columns = [])
    {
        $ph_columns = [];
        if (!empty($columns)) {
            foreach ($columns as $key => $value) {
                $ph_columns[':' . $key] = $value;
            }
        }
        $result = self::$db->prepare($query);
        $result->execute($ph_columns);
        return $result;
    }

    public static function fetchAll($obj, $deleted = 'ALL')
    {
//        if (false === self::$db) {
//            self::init();
//        }
        $query = 'SELECT * FROM '. $obj::$table_name;
        if ('DELETED' == $deleted) {
            $query .= ' WHERE deleted=1';
        } elseif ('ACTIVE' == $deleted) {
            $query .= ' WHERE deleted=0';
        }
        $result = self::query($query);
        return $result->fetchAll();
    }

    public static function fetchById($obj, int $id, $deleted = 'ALL')
    {
//        if (false === self::$db) {
//            self::init();
//        }
        $query = 'SELECT * FROM '. $obj::$table_name . ' WHERE id=:id';
        if ('DELETED' == $deleted) {
            $query .= ' AND deleted=1';
        } elseif ('ACTIVE' == $deleted) {
            $query .= ' AND deleted=0';
        }
        $result = self::query($query, ['id' => $id]);
        return $result->fetchAll();
    }

    private function insert($obj)
    {
        $query = 'INSERT INTO '. $obj::$table_name
            .' (' . implode(',', array_keys($obj->data)) . ')'
         .' VALUES (:' . implode(',:', array_keys($obj->data)) . ')';
        return self::query($query, $obj->data);
    }

    private function update($obj)
    {
        $query = 'UPDATE '. $obj::$table_name . ' SET ';
        foreach (array_keys($obj->data) as $key) {
            if ('id'==$key) {
                continue;
            }
            $query .=  $key .'=:'.$key.',';
        }
        $query = substr($query, 0, -1);
        $query .= ' WHERE id=:id';
        return self::query($query, $obj->data);
    }

    public function save($obj)
    {
        if (!isset($obj->id)) {
            $this->insert($obj);
            echo $obj->id = self::$db->lastInsertId();
        } else {
            $this->update($obj);
        }
    }

    public function delete($obj)
    {
        $query = 'UPDATE '. $obj::$table_name . ' SET ' .
            'deleted=1';
        $query .= ' WHERE id=:id';
        return self::query($query, $obj->data);
    }

    public function unDelete($obj)
    {
        $query = 'UPDATE '. $obj::$table_name . ' SET ' .
            'deleted=0';
        $query .= ' WHERE id=:id';
        return self::query($query, $obj->data);
    }
}
