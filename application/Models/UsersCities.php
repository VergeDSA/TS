<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class UsersCities extends ActiveRecord
{
    protected static $table_name = 'users_cities';
    protected static $table_fields = ['id', 'user_id', 'city_id'];
}
