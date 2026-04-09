<?php
$routes->group('api',['namespace' => 'App\Controllers\Api'],function($routes){
    $routes->group('users', function($routes){
        $routes->get('all', 'User::index');
        $routes->get('(:num)', 'User::show/$1');
    });
    $routes->group('exercices', ['filter' => 'apitoken'], function($routes){
        $routes->get('all', 'Exercice::index');
        $routes->get('(:num)', 'Exercice::show/$1');
    });
    $routes->group('programs', ['filter' => 'apitoken'], function($routes){
        $routes->get('all', 'Program::index');
        $routes->get('user/(:num)', 'Program::showall/$1');
        $routes->get('(:num)', 'Program::show/$1');
        $routes->post('create', 'Program::create');
        $routes->post('update/(:num)', 'Program::update/$1');
        $routes->post('delete', 'Program::delete');
        $routes->group('workout', ['filter' => 'apitoken'], function($routes){
            $routes->get('all', 'Workout::index');
            $routes->get('(:num)', 'Workout::show/$1');
        });
    });
    $routes->group('muscles', ['filter' => 'apitoken'], function($routes){
        $routes->get('all', 'Muscle::index');
        $routes->get('(:num)', 'Muscle::show/$1');
    });
    $routes->group('category', ['filter' => 'apitoken'], function($routes){
        $routes->get('all', 'Category::index');
        $routes->get('(:num)', 'Category::show/$1');
    });
    $routes->group('auth', function($routes) {
        $routes->post('login', 'Auth::login');
    });
});