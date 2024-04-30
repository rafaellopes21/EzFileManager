<?php
//https://docs.flightphp.com/learn/routing
$route = Flight::router();

$route->get('/', [new \App\Controller\ManagerController(), 'index']);
$route->get('/list', [new \App\Controller\ManagerController(), 'list']);

$route->group('/languages', function () use ($route){
    $route->get('/', [new \App\Controller\LanguagesController(), 'index']);
    $route->post('/change', [new \App\Controller\LanguagesController(), 'change']);
    $route->post('/pick', [new \App\Controller\LanguagesController(), 'pick']);
    $route->post('/create', [new \App\Controller\LanguagesController(), 'create']);
    $route->post('/delete', [new \App\Controller\LanguagesController(), 'delete']);
});

$route->group('/user', function () use ($route){
    $route->get('/', [new \App\Controller\UserController(), 'index']);
    $route->post('/update', [new \App\Controller\UserController(), 'update']);
    $route->get('/list', [new \App\Controller\UserController(), 'list']);
    $route->post('/icon-change', [new \App\Controller\UserController(), 'iconChange']);
});

$route->group('/form', function () use ($route){
    $route->get('/copy', [new \App\Controller\FormController(), 'copy']);
    $route->get('/move', [new \App\Controller\FormController(), 'move']);
    $route->get('/rename', [new \App\Controller\FormController(), 'rename']);
    $route->get('/upload-file', [new \App\Controller\FormController(), 'uploadFile']);
    $route->get('/upload-folder', [new \App\Controller\FormController(), 'uploadFolder']);
});

$route->group('/api', function () use ($route){
    $route->post('/refresh', [new \App\Controller\ManagerController(), 'refresh']);
    $route->post('/upload', [new \App\Controller\ManagerController(), 'upload']);
    $route->post('/delete', [new \App\Controller\ManagerController(), 'delete']);
    $route->post('/rename', [new \App\Controller\ManagerController(), 'rename']);
    $route->post('/copy', [new \App\Controller\ManagerController(), 'copy']);
    $route->post('/move', [new \App\Controller\ManagerController(), 'move']);
    $route->get('/download', [new \App\Controller\ManagerController(), 'download']);
});

$route->group('/login', function () use ($route){
    $route->get('/', [new \App\Controller\UserController(), 'login']);
    $route->post('/', [new \App\Controller\UserController(), 'login']);
});
$route->get('/logout', [new \App\Controller\UserController(), 'logout']);

Flight::start();