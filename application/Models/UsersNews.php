<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class UsersNews extends ActiveRecord
{
    protected static $table_name = 'users_news';
    protected static $table_fields = ['id','news_id','user_id'];
}
