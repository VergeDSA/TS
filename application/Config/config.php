<?php
define('APPLICATION_FOLDER', ROOT_FOLDER . '/application');
define('CONTROLLERS_FOLDER', '\\App\\Controllers\\');
define('MODELS_FOLDER', '\\App\\Models\\');
define('VIEWS_FOLDER', '\\App\\Views\\');
ini_set('session.save_path', ROOT_FOLDER . '/data/sessions');
ini_set('session.gc_probability', 100);
ini_set('session.gc_maxlifetime', 10);
