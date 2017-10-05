<?php

require '../Core/Router.php';

$router = new Router();

// Add routes here
$router->add('', [
    'controller' => 'Home',
    'action' => 'index'
]);

$router->add('{controller}/{action}');
$router->add('admin/{controller}/{id:\d+}/{action}');

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}
