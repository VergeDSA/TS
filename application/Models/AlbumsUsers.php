<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class AlbumsUsers extends ActiveRecord
{
    protected static $table_name = 'albums_users';
    protected static $table_fields = ['id', 'user_id', 'album_id'];
}
