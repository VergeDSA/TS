<?php

namespace App\Controllers;

class SiteController extends PageController
{
    protected function getTemplateNames()
    {
        $this->templateInfo['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlecolumn',
            'rightcolumn',
            'footer'];
    }
}
