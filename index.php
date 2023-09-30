<?php

use service\Router;

require __DIR__ . '/vendor/autoload.php';

require_once 'app/routes.php';

session_start();
Router::start();