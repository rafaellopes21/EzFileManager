<?php
//https://docs.flightphp.com/learn/routing
$route = Flight::router();

$route->get('/', [new \App\Controller\ManagerController(), 'index']);

$route->group('/languages', function () use ($route){
    $route->get('/', [new \App\Controller\LanguagesController(), 'index']);
    $route->post('/change', [new \App\Controller\LanguagesController(), 'change']);
    $route->post('/pick', [new \App\Controller\LanguagesController(), 'pick']);
    $route->post('/create', [new \App\Controller\LanguagesController(), 'create']);
    $route->post('/delete', [new \App\Controller\LanguagesController(), 'delete']);
});

$route->group('/user', function () use ($route){
    $route->get('/', [new \App\Controller\UserController(), 'index']);
});

$route->group('/login', function () use ($route){
    $route->get('/', [new \App\Controller\UserController(), 'login']);
    $route->post('/', [new \App\Controller\UserController(), 'login']);
});
$route->get('/logout', [new \App\Controller\UserController(), 'logout']);


Flight::start();