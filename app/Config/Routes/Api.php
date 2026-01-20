<?php
$routes->group('api',['namespace' => 'App\Controllers\Api'],function($routes){
    $routes->group('users', function($routes){
        $routes->get('all', 'User::index');
        $routes->get('(:num)', 'User::show/$1');
    });
    $routes->group('exercices', function($routes){
        $routes->get('all', 'Exercice::index');
        $routes->get('(:num)', 'Exercice::show/$1');
    });
    $routes->group('auth', function($routes) {
        $routes->post('login', 'Auth::login');
    });
});