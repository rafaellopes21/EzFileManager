<?php //https://docs.flightphp.com/learn/routing
$route = Flight::router();

/*$route->get('/', function (){
    //include __DIR__.'/../../resources/views/index.php';
    //Flight::render('index.php', ['body' => 'Hello World']);
});*/

$route->get('/', [new \App\Controller\IndexController(), 'index']);

Flight::start();