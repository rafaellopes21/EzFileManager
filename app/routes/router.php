<?php
//https://docs.flightphp.com/learn/routing
$route = Flight::router();

/*
 Flight::route('/stream-usuários', function() {

    // como você obtém seus dados, apenas como exemplo...
    $users_stmt = Flight::db()->query("SELECT id, first_name, last_name FROM users");

    echo '{';
    $user_count = count($users);
    while($user = $users_stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($user);
        if(--$user_count > 0) {
            echo ',';
        }

        // Isso é necessário para enviar os dados para o cliente
        ob_flush();
    }
    echo '}';

// Assim você definirá os cabeçalhos antes de começar a transmitir.
})->streamWithHeaders([
    'Content-Type' => 'application/json',
    // código de status opcional, padrão 200
    'status' => 200
]);
 */

/*$route->group('/', function () use ($route){
    $route->get('', [new \App\Controller\ManagerController(), 'index']);
});*/

$route->get('/', [new \App\Controller\ManagerController(), 'index']);
$route->get('/languages', [new \App\Controller\ManagerController(), 'languages']);

Flight::start();