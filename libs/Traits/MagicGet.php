<?php

namespace Libs\Traits;

trait MagicGet
{
    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }
}
