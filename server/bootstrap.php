<?php

//Include all dependencies of our application
require_once 'vendor/autoload.php';

require_once 'config/helpers.php';

require_once 'config/cors.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

new App\Core\Database();

new App\Core\Router();
