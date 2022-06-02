<?php 


header('Content-Type: application/json');


require_once '../app/autoload.php'; 

// Autoloader::register(); 

require_once '../router/RestRouter.php';

$host = $_SERVER['REQUEST_URI'];

$router = new RestRouter($host);
$router->get('/api/item/:id/item/:name', function (){
    echo "salut a toi";
});
$router->run();


?>