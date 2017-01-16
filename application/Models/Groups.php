<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Groups extends ActiveRecord
{
    protected static $table_name = 'groups';
    protected static $table_fields = ['id', 'name', 'description', 'status'];
}
