<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 26.12.16
 * Time: 3:32
 */

namespace Libs\Traits;

trait GetTableProperties
{
    public static function getTableName()
    {
        return static::$table_name;
    }
    public static function getTableFields()
    {
        return static::$table_fields;
    }
}
