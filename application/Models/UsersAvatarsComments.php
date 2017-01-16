<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class UsersAvatarsComments extends ActiveRecord
{
    protected static $table_name = 'users_avatars_comments';
    protected static $table_fields = ['id', 'user_avatar_id', 'comment_id'];
}
