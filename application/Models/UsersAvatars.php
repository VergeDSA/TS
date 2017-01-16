<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class UsersAvatars extends ActiveRecord
{
    protected static $table_name = 'users_avatars';
    protected static $table_fields = ['id', 'user_id','file_name','status'];

    public static function getByCondition($condition, $addCondition="")
    {
        $result = parent::getByCondition($condition, $addCondition);
        if (count($result) == 0) {
            $result = new UserAvatar();
            $result->userId = $condition['userId'];
            $result->fileName = 'default.jpeg';
            return $result;
        }
        return $result[0];
    }
}
