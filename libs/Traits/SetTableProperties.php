<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 26.12.16
 * Time: 3:32
 */

namespace Libs\Traits;

trait SetTableProperties
{
    public static function pushTableFields($field)
    {
        array_push(static::$table_fields, $field);
    }
    public static function popTableFields()
    {
        return array_pop(static::$table_fields);
    }
}
