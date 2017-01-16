<?php
namespace App\Classes;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 13.12.16
 * Time: 11:27
 */

Class Template
{
    private $parts;
    private $vars = [];

    public function __construct($args)
    {
        $this->parts = $args['templateNames'];
        $this->vars = $args;
    }
    function show($directory)
    {
        // Load variables
        extract($this->vars);

        // Show
        foreach ($this->parts as $part) {
            $path = ROOT . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $part . '.php';
            if (!file_exists($path)) {
                trigger_error('Template `' . $part . '` does not exist.', E_USER_NOTICE);
                return false;
            }
            include ($path);
        }
    }
}
