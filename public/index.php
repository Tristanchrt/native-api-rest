<?php 


header('Content-Type: application/json; charset=utf-8');


require_once '../app/autoload.php'; 

Autoloader::register(); 

require_once '../router/RestRouter.php';

$host = $_SERVER['REQUEST_URI'];

$router = new RestRouter($host);

$router->groups('api/', function($router) {
    $router->groups('item/', function($router) {
        $router->get(':id/item/:name', "ItemController@get_items");
        $router->post(':id', "ItemController@get_items");
        $router->groups('item/', function($router) { 
            $router->post(':id', "ItemController@get_items");
        });
    });
});

$router->run();


?>