<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Utils\StringUtils;

class Bootstrap {

    public static function init() 
    {
        Router::route(StringUtils::cleanUri(trim($_SERVER['REQUEST_URI'], '/')), $_SERVER['REQUEST_METHOD']);
    }

}
