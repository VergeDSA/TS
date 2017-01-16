<?php

use App\Controllers\ReaderController;
use PHPUnit\Framework\TestCase;


class ReaderControllerTest extends TestCase
{
    public function testIndexAction()
    {
        $readerController = new ReaderController();
        ob_start();
        $readerController->actionIndex();
        $result = ob_get_clean();

        $this->assertEquals('ReaderController actionIndex', $result);
    }



    public function testIndexActionFunctional()
    {
        define('ROOT_FOLDER', __DIR__ . '/..');
        $_SERVER['REQUEST_URI'] = 'readers';
        ob_start();

        $app = new Libs\Framework\Application();
        $app->sapi = 'apache';
        $app->run();
        $result = ob_get_clean();

        $this->assertEquals('ReaderController actionIndex', $result);
    }

    /**
     * @dataProvider indexDataProvider
     */
    public function testIndexActionFunctionalWithDP($requestURI, $expectedResult)
    {
        define('ROOT_FOLDER', __DIR__ . '/..');
        $_SERVER['REQUEST_URI'] = $requestURI;
        ob_start();

        $app = new Libs\Framework\Application();
        $app->sapi = 'apache';
        $app->run();
        $result = ob_get_clean();

        $this->assertEquals($expectedResult, $result);
    }

    public function indexDataProvider()
    {
        return [
            ['readers', 'ReaderController actionIndex'],
            ['reader/oneindex/1', 'ReaderController actionOneIndex'],
        ];
    }

}