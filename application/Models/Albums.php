<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Albums extends ActiveRecord
{
    protected static $table_name = 'albums';
    protected static $table_fields = ['id', 'name'];
}
