#!/usr/bin/env php
<?php

use Hyperf\Contract\ApplicationInterface;
use Hyperf\Di\ClassLoader;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '512M');

error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

require BASE_PATH . '/vendor/autoload.php';

(function () {
    ClassLoader::init();
    $container = require BASE_PATH . '/config/container.php';
    $application = $container->get(ApplicationInterface::class);
    $application->run();
})();
