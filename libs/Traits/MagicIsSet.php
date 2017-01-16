<?php

namespace Libs\Traits;

trait MagicIsSet
{
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }
}
