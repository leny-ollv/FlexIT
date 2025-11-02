<?php
$routes->get('/', 'Home::index');
$routes->get('/forbidden','Site::forbidden');

$routes->get('/test','Site::test');

$routes->get('/sign-in', 'Auth::signIn');
$routes->get('/register', 'User::register');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

//dataTable
$routes->post('/datatable/searchdatatable', 'DataTable::searchdatatable');