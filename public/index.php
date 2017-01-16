<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 30.11.16
 * Time: 15:35
 */

/*
 * Error output enabled
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
ob_start();
define('ROOT_FOLDER', __DIR__ . '/..');
require ROOT_FOLDER . '/application/Config/config.php';
$loader = require ROOT_FOLDER.'/vendor/autoload.php';
$app = new \Libs\Framework\Application();
$app->run();
