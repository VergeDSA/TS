<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Messages extends ActiveRecord
{
    protected static $table_name = 'messages';
    protected static $table_fields = ['id', 'sender_id', 'receiver_id', 'text', 'status'];
}
