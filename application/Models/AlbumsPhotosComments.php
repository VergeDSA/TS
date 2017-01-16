<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class AlbumsPhotosComments extends ActiveRecord
{
    protected static $table_name = 'albums_photos_comments';
    protected static $table_fields = ['id', 'comment_id', 'albums_photos_id'];
}
