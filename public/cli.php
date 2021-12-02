<?php

if (PHP_SAPI != "cli") exit;

require '../vendor/autoload.php';

use Onion\Container\Application;

$app = new Application(realpath(dirname(__DIR__)));

$app->kernel->cli('Home\WebsocketController@server');