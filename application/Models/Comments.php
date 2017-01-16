<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Comments extends ActiveRecord
{
    protected static $table_name = 'comments';
    protected static $table_fields = ['id', 'user_id', 'text', 'status', 'published'];
}
