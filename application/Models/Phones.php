<?php

namespace App\Models;

use Libs\ActiveRecord\ActiveRecord;

class Phones extends ActiveRecord
{
    protected static $table_name = 'phones';
    protected static $table_fields = ['id', 'user_id', 'phone'];
}
