<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class AlbumsPhotos extends ActiveRecord
{
    protected static $table_name = 'albums_photos';
    protected static $table_fields = ['id', 'album_id', 'file_name', 'description', 'status'];
}
