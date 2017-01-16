<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Passwords extends ActiveRecord
{
    protected static $table_name = 'passwords';
    protected static $table_fields = ['id','user_id','password'];
}
