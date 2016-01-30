<?php

require_once(__DIR__.'/../framework/Loader.php');

Loader::addNamespacePath('Blog\\',__DIR__.'/../src/Blog');

$app = new \Framework\Application(__DIR__.'/../app/config/config.php');

$app->run();