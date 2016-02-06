<?php

/**
 * Added displaying warnings and errors, because Ubuntu 14.04 LTS ignores php.ini
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once(__DIR__.'/../framework/Loader.php');

Loader::addNamespacePath('Blog\\',__DIR__.'/../src/Blog');

$app = new \Framework\Application(__DIR__.'/../app/config/config.php');

$app->run();