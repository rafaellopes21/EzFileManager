<?php
//https://docs.flightphp.com/learn/routing
$route = Flight::router();

$route->get('/', [new \App\Controller\ManagerController(), 'index']);
$route->get('/languages', [new \App\Controller\ManagerController(), 'languages']);
$route->post('/languages/change', [new \App\Controller\ManagerController(), 'langChanger']);

Flight::start();