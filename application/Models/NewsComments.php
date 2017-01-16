<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class NewsComments extends ActiveRecord
{
    protected static $table_name = 'news_comments';
    protected static $table_fields = ['id', 'news_id', 'comment_id'];
}
