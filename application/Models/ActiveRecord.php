<?php
namespace App\Models;

use Libs\Framework\Db;

/**
 * ActiveRecord Class
 *
 * Абстрактный класс, реализующий базовый функционал работы с записями в таблицах
 * БД в соответствии с шаблоном Active Record
 *
 * @author А.Бричак <brichak.new@gmail.com>
 * @version 1.0
 */

abstract class ActiveRecord
{
    /**
     * Подключение к БД
     *
     * @var \PDO
     */
    private static $db;

    /**
     * Строка с SQL-запросом
     *
     * @var string
     */
    private static $queryString;

    /**
     * Имя таблицы БД, которой соответствует модель
     *
     * @var string
     */
    protected static $tableName;

    /**
     * Ассоциативный массив: ключ - название поля таблицы в БД, значение -
     * название поля объекта-модели
     *
     * @var array
     */
    protected static $tableFields = [];

    /**
     * Ассоциативный массив: ключ - название модели, к которой присоединяются
     * другие модели; значение - индексированный массив, каждый элемент которого
     * - это ассоциативный массив с параметрами присоединения. Позволяет
     * создавать цепочки или деревья зависимостей классов моделей
     *
     * @var array
     */
    protected static $joinedModel = [];


    /**
     * Подключается к БД, используя класс Db
     *
     * @return void
     */
    private static function setDB()
    {
        self::$db = Db::getConnection();
    }


    /**
     * Формирует строку со списком полей таблицы БД для запроса select
     *
     * @return string <p>Список полей в формате: имя_таблицы.поле_таблицы AS полеМодели</p>
     */
    private static function getFieldsSelect()
    {
        $pieces = [];
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            array_push($pieces, static::$tableName.".$fieldDB AS $fieldObject");
        }
        return implode(", ", $pieces);
    }


    /**
     * Формирует строку со списком полей таблицы БД и параметров для
     * подготавливаемого запроса update
     *
     * @return string <p>Список полей в формате: поле_таблицы=:параметрЗапроса</p>
     */
    private function getFieldsUpdate()
    {
        $pieces = [];
        $fields = get_object_vars($this);
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($fields[$fieldObject]) && $fieldDB != "id") {
                array_push($pieces, "$fieldDB=:$fieldObject");
            }
        }
        return implode(", ", $pieces);
    }


    /**
     * Формирует массив из двух строк со списком полей таблицы БД и списком
     * параметров для подготавливаемого запроса insert
     *
     * @return string[] <p>Список полей таблицы; список наименований параметров запроса</p>
     */
    private function getFieldsInsert()
    {
        $piecesColumns = [];
        $piecesParams = [];
        $fields = get_object_vars($this);
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($fields[$fieldObject]) && $fieldDB != "id") {
                array_push($piecesColumns, $fieldDB);
                array_push($piecesParams, ":$fieldObject");
            }
        }
        return [implode(", ", $piecesColumns), implode(", ", $piecesParams)];
    }


    /**
     * Формирует строку со списком условий выборки для подготавливаемого запроса
     * select. Условия выборки задаются в виде равенства полей таблицы
     * передаваемым в функцию значениям
     *
     * @param array $condition Ассоциативный массив условий выборки в формате:
     * [полеМодели => значение]
     *
     * @return string <p>Список условий выборки в формате: поле_таблицы=:параметрЗапроса</p>
     */
    private static function getDBCondition($condition)
    {
        $pieces = [];
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($condition[$fieldObject])) {
                array_push($pieces, "$fieldDB=:$fieldObject");
            }
        }
        return implode(" AND ", $pieces);
    }


    /**
     * Запускает выполнение подготовленного SQL-запроса
     *
     * @param array $queryParams Ассоциативный массив параметров запроса
     * в формате: [полеМодели => значение]
     * @param string $action Вид запроса: select, insert, update или delete
     *
     * @return mixed <p>Для запросов update и delete не возвращает ничего.
     * Для запроса insert возвращает id последней добавленной записи.
     * Для запроса select возвращает результат в виде массива объектов-
     * моделей, соответствующих вызывающему классу модели</p>
     */
    private static function execSQL($queryParams, $action)
    {
        self::setDB();
        $className = get_called_class();
        $query = self::$db->prepare(self::$queryString);
        $queryResult = $query->execute($queryParams);
        if ($queryResult && $action == 'insert') {
            return (self::$db)->lastInsertId();
        }
        if ($action == 'update' || $action == 'delete') {
            return;
        }
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $object = new $className();
            foreach ($row as $field => $value) {
                $object->{$field} = $value;
            }
            array_push($result, $object);
        }
        return $result;
    }


    /**
     * Запускает рекурсивный алгоритм поиска присоединенных (joined) моделей
     * на основании дерева присоединения моделей; выбирает из БД и создает
     * соответствующие массивы вложенных объектов. Вызывается из функций
     * getByID и getByCondition
     *
     * @param array $rows Массив объектов-моделей, созданных функциями
     * getByID и getByCondition
     *
     * @return array <p>Массив объектов-моделей, в котором каждый объект
     * содержит вложенные объекты-модели (массивы объектов-моделей)</p>
     */
    private static function getJoin($rows)
    {
        $className = get_called_class();
        if (! isset(self::$joinedModel[$className])) {
            return $rows;
        }
        foreach (self::$joinedModel[$className] as $joinBranch) {
            extract($joinBranch);
            $joinedNameShort = substr($joinedName, strrpos($joinedName, '\\') + 1);
            foreach ($rows as $row) {
                if ($joinedKey == 'id') {
                    $value = $joinedName::getByID($row->{$thisKey});
                } else {
                    $value = $joinedName::getByCondition([$joinedKey => $row->{$thisKey}], $addCondition);
                }
                $row->{lcfirst($joinedNameShort)} = $value;
            }
        }
        return $rows;
    }


    /**
     * Регистрирует присоединение (join) моделей в статическом массиве $joinedModel
     *
     * @param string $thisKey Имя поля текущей таблицы, по которому проводится join
     * @param string $joinedName Имя присоединяемой таблицы
     * @param string $joinedKey Имя поля присоединяемой таблицы, по которому
     * проводится join
     * @param string $addCondition Необязательная строка дополнительных условий
     * выборки при соединении таблиц
     *
     * @return void
     */
    public static function join($thisKey, $joinedName, $joinedKey, $addCondition="")
    {
        $className = get_called_class();
        self::$joinedModel[$className] = self::$joinedModel[$className] ?? [];
        array_push(self::$joinedModel[$className], compact('thisKey', 'joinedName', 'joinedKey', 'addCondition'));
    }


    /**
     * Очищает статический массив $joinedModel
     *
     * @return void
     */
    public static function clearJoins()
    {
        self::$joinedModel = [];
    }


    /**
     * Выбирает из таблицы БД запись по заданному id; создает соответствующий
     * объект-модель; запускает рекурсивную функцию getJoin для прохождения
     * дерева присоединения моделей
     *
     * @param int $id id записи в таблице БД
     *
     * @return mixed <p>Объект-модель, соответствующий записи в БД</p>
     */
    public static function getByID($id)
    {
        $fields = self::getFieldsSelect();
        self::$queryString = "SELECT $fields FROM " . static::$tableName . " WHERE id=:id";
        $result = self::execSQL(['id' => $id], 'select');
        return (self::getJoin($result))[0];
    }


    /**
     * Выбирает из таблицы БД записи по заданным условиям; создает массив
     * соответствующих объектов-моделей; запускает рекурсивную функцию getJoin
     * для прохождения дерева присоединения моделей
     *
     * @param array $condition Ассоциативный массив параметров выборки в формате:
     * [полеМодели => значение]
     * @param string $addCondition Необязательная строка дополнительных условий выборки
     *
     * @return mixed <p>Массив объектов-моделей, соответствующих записям в БД</p>
     */
    public static function getByCondition($condition, $addCondition="")
    {
        $fields = self::getFieldsSelect();
        $conditionString = self::getDBCondition($condition);
        self::$queryString = "SELECT $fields FROM " . static::$tableName . " WHERE $conditionString $addCondition";

        $result = self::execSQL($condition, 'select');
        return self::getJoin($result);
    }


    /**
     * По заданному id устанавливает записи в таблице БД флаг deleted=1
     *
     * @param int $id id записи в таблице БД
     *
     * @return void
     */
    public static function deleteSoft($id)
    {
        self::$queryString = "UPDATE " . static::$tableName . " SET deleted=1 WHERE id=:id";
        self::execSQL(['id' => $id], 'update');
    }


    /**
     * По заданному id удаляет запись из таблицы БД
     *
     * @param int $id id записи в таблице БД
     *
     * @return void
     */
    public static function delete($id)
    {
        self::$queryString = "DELETE FROM " . static::$tableName . " WHERE id=:id";
        self::execSQL(['id' => $id], 'delete');
    }


    /**
     * С помощью запроса update устанавливает значения полей записи в БД на
     * основании значений полей объекта-модели
     *
     * @return void
     */
    public function update()
    {
        $fields = self::getFieldsUpdate();
        self::$queryString = "UPDATE " . static::$tableName . " SET $fields  WHERE id=:id";
        self::execSQL(get_object_vars($this), 'update');
    }


    /**
     * Создает новую запись в таблице БД со значениями полей, равными значениям
     * полей объекта-модели
     *
     * @return void
     */
    public function insert()
    {
        list ($columns, $params) = self::getFieldsInsert();
        self::$queryString = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($params)";
        $this->id = self::execSQL(get_object_vars($this), 'insert');
    }


    /**
     * Выбирает из таблицы БД количество записей, соответствующих заданным условиям
     *
     * @param array $condition Ассоциативный массив параметров выборки в формате:
     * [полеМодели => значение]
     * @param string $addCondition Необязательная строка дополнительных условий выборки
     *
     * @return int <p>Количество записей</p>
     */
    public static function count($condition, $addCondition="")
    {
        $conditionString = self::getDBCondition($condition);
        self::$queryString = "SELECT COUNT(*) AS count FROM " . static::$tableName . " WHERE $conditionString $addCondition";
        return (self::execSQL($condition, 'select'))[0]->count;
    }
}
