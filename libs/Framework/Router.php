<?php

namespace Libs\Framework;

class Router
{
    private $routes = [];
    public $uri;

    public function __construct()
    {
        $this->routes = include APPLICATION_FOLDER . '/Config/routes.php';
        $this->uri = $this::getUri();
//        SessionClass::start();
    }

    public static function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function execute()
    {
        foreach ($this->routes as $pattern => $path) {
            if (preg_match("~$pattern~", $this->uri)) {
                $path = preg_replace("~$pattern~", $path, $this->uri);
                $parse_path = explode('/', $path);
                $controller_name = CONTROLLERS_FOLDER . ucfirst(array_shift($parse_path)) . 'Controller';
                $method_name = 'action'.ucfirst(array_shift($parse_path));
                return array(
                    'controller_name' => $controller_name,
                    'method_name' => $method_name,
                    'params_array' => $parse_path);
            }
        }
    }
}
