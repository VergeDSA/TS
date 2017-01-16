<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 30.11.16
 * Time: 22:11
 */
return [
    // User:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    // Management users: (future)
    //'admin/user/create' => 'adminUser/create',
    //'admin/user/update/([0-9]+)' => 'adminUser/update/$1',
    //'admin/user/delete/([0-9]+)' => 'adminUser/delete/$1',
    //'admin/user' => 'adminUser/index',
    // Admin panel:
    // 'admin' => 'admin/index',
    //Managing the user profile
    'profile/show' => 'profile/show',
    'profile/edit' => 'profile/edit',
    'profile/update' => 'profile/update',
    'profile/input' => 'profile/input',
    'profile/insert' => 'profile/insert',
    'profile/delete' => 'profile/delete',
    // Main page
    'index.php' => 'site/index', // actionIndex in SiteController
    '' => 'site/index', // actionIndex in SiteController
];
