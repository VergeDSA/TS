<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 11.12.16
 * Time: 2:02
 */

namespace Libs\Framework;

class View
{
    protected $data = [];
    public function assign($name, $value)
    {
        $this->data[$name] = $value;
    }
    public function display($template)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }
        ob_end_flush();
        include APPLICATION_FOLDER . '/Views'.$template.'.php';
    }
}
