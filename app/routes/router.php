<?php
//https://docs.flightphp.com/learn/routing
$route = Flight::router();

$route->get('/', [new \App\Controller\ManagerController(), 'index']);
$route->get('/languages', [new \App\Controller\LanguagesController(), 'index']);
$route->post('/languages/change', [new \App\Controller\LanguagesController(), 'change']);
$route->post('/languages/pick', [new \App\Controller\LanguagesController(), 'pick']);
$route->post('/languages/create', [new \App\Controller\LanguagesController(), 'create']);
$route->post('/languages/delete', [new \App\Controller\LanguagesController(), 'delete']);

Flight::start();