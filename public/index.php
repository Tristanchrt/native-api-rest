<?php 


header('Content-Type: application/json; charset=utf-8');


require_once '../app/autoload.php'; 

Autoloader::register(); 

require_once '../router/RestRouter.php';

$host = $_SERVER['REQUEST_URI'];

$router = new RestRouter($host);
$router->get('/api/item/:id/item/:name', function ($request){
    echo json_encode($request);
});
$router->post('/api/item/:id', "ItemController@get_items");
$router->run();


?>