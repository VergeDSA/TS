<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 26.12.16
 * Time: 1:56
 */

namespace Libs\Framework;

class Application
{
    public $sapi;
    public $router;
    public $paths = [];

    public function __construct()
    {
        $this->sapi = php_sapi_name();
    }
    public function whatInterface()
    {
        if ('cli' == $this->sapi) {
            die('Запуск из командной строки');
        } elseif ('cgi' == substr($this->sapi, 0, 3)) {
            die('Запуск в режиме CGI');
        } elseif ('apache' == substr($this->sapi, 0, 6)) {
            return 'apache';
        } else {
            die('Запуск в режиме модуля сервера '.$this->sapi);
        }
    }
    public function run()
    {
        if ('apache' == $this->whatInterface()) {
            $this->router = new Router();
            $path_finder = $this->router->execute();
            $class = new $path_finder['controller_name']();
            if (is_callable([$class, $path_finder['method_name']])) {
                if (count($path_finder['params_array']) > 0) {
                    call_user_func_array(array($class, $path_finder['method_name']), $path_finder['params_array']);
                } else {
                    $class->{$path_finder['method_name']}();
                }
            } else {
                $class->index($path_finder['method_name'], $path_finder['params_array']);
            }
        }
    }
}
