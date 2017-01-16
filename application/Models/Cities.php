<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Cities extends ActiveRecord
{
    protected static $table_name = 'cities';
    protected static $table_fields = ['id', 'country_id', 'name'];
}
