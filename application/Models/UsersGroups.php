<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class UsersGroups extends ActiveRecord
{
    protected static $table_name = 'users_groups';
    protected static $table_fields = ['id','group_id','user_id'];
}
