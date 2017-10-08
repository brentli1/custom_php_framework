<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// Set error handler
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler'); 

$router = new AltoRouter();

// Add routes here
$router->map('GET', '/posts', 'App\Controllers\PostsController#index');

$match = $router->match();

if($match) {
    $target = $match["target"];
    if(strpos($target, "#") !== false) {
        list($controller, $action) = explode("#", $target);
        $controller = new $controller([]);
        $controller->$action($match["params"]);
    } else {
        if(is_callable($match["target"])) call_user_func_array($match["target"], $match["params"]);
        else require $match["target"];
    }
} else {
    throw new \Exception('Route not found.', 404);
}
