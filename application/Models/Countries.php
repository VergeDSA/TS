<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Countries extends ActiveRecord
{
    protected static $table_name = 'countries';
    protected static $table_fields = ['id', 'name'];
}
