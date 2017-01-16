<?php
namespace App\Classes;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 13.12.16
 * Time: 14:52
 */

class Application
{
    private $config;
    public $router;
    private $templateInfo;
    private $template;
    private $controller;
    private static $instance;



    private function doProcess ()
    {
        if (is_callable([$this->controller['ref'], $this->controller['actionName']])) {
            $this->templateInfo = call_user_func_array([$this->controller['ref'], $this->controller['actionName']], $this->controller['args']);
        } else {
            $this->templateInfo = $this->controller['ref']->index($this->controller['actionName'], $this->controller['args']);
        }
    }
    private function process ()
    {
        $this->controller = $this->router->run();
        $this->doProcess();
    }
    private function setTemplate()
    {
        $this->template = new Template($this->templateInfo);
    }
    private function render ()
    {
        $this->setTemplate();
        $this->template->show("App/" . $this->config['templatesPath']);
    }
    public function run()
    {
        $this->initialize();
        $this->process();
        $this->render();

    }
}
