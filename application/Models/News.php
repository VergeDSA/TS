<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class News extends ActiveRecord
{
    protected static $table_name = 'news';
    protected static $table_fields = ['id', 'title', 'text', 'picture', 'status', 'published'];
}
