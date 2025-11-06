<?php
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth:administrateur'], function ($routes) {
    //Routes vers le tableau de bord
    $routes->get('dashboard', 'Admin::dashboard');

    $routes->group('user', function ($routes) {
        $routes->get('/', 'User::index');
        $routes->get('(:num)', 'User::edit/$1');
        $routes->get('new', 'User::create');
        $routes->post('update', 'User::update');
        $routes->post('insert', 'User::insert');
        $routes->post('switch-active','User::switchActive');
        $routes->get('search', 'User::search');
    });

    $routes->group('user-permission', function ($routes) {
       $routes->get('/', 'UserPermission::index');
       $routes->post('update', 'UserPermission::update');
       $routes->post('insert', 'UserPermission::insert');
       $routes->post('delete', 'UserPermission::delete');
    });

    $routes->group('program', function ($routes) {
        $routes->get('/', 'Program::index');
        $routes->get('new', 'Program::create');
        $routes->get('(:num)', 'Program::edit/$1');
        $routes->post('save', 'Program::save');
        $routes->get('edit/(:num)', 'Program::edit/$1');
        $routes->post('delete', 'Program::delete');
    });

    $routes->group('workout', function($routes) {
        $routes->get('create/(:num)', 'Workout::create/$1');
        $routes->post('save', 'Workout::save');
        $routes->get('edit/(:num)', 'Workout::edit/$1');
        $routes->get('delete/(:num)/(:num)', 'Workout::delete/$1/$2');
    });

    $routes->group('exercise', function ($routes) {
        $routes->get('/', 'Exercise::index');
        $routes->get('new', 'Exercise::create');
        $routes->get('(:num)', 'Exercise::edit/$1');
        $routes->post('save', 'Exercise::save');
        $routes->post('delete', 'Exercise::delete');
        $routes->get('series/(:num)', 'Exercise::getSeries/$1');
    });

    $routes->group('category', function ($routes) {
        $routes->get('/', 'Category::index');
        $routes->get('new', 'Category::create');
        $routes->get('(:num)', 'Category::edit/$1');
        $routes->post('save', 'Category::save');
        $routes->post('delete', 'Category::delete');
    });

    $routes->group('categories_prgm', function ($routes) {
        $routes->get('/', 'CategoriesPrgm::index');
        $routes->get('new', 'CategoriesPrgm::create');
        $routes->get('(:num)', 'CategoriesPrgm::edit/$1');
        $routes->post('save', 'CategoriesPrgm::save');
        $routes->post('delete', 'CategoriesPrgm::delete');
    });

    $routes->group('muscle', function ($routes) {
        $routes->get('/', 'Muscle::index');
        $routes->get('new', 'Muscle::create');
        $routes->get('(:num)', 'Muscle::edit/$1');
        $routes->post('save', 'Muscle::save');
        $routes->post('delete', 'Muscle::delete');
    });
});

