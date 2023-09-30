<?php

use service\Router;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/service/helpers.php';

require_once 'app/routes.php';

session_start();
Router::start();