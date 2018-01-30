<?php

session_start();

putenv('PUBLIC_ROOT=' . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    putenv($key . '=' . $value);
}

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

include_once __DIR__ . '/../app/routes.php';

$router = new Router();
$router->execute($routes);
