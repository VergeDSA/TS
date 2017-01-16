<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Friends extends ActiveRecord
{
    protected static $table_name = 'friends';
    protected static $table_fields = ['id', 'user_sender', 'user_receiver', 'status'];
}
