<?php

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\LoginController;
use CodeIgniter\Router\AdminController;
use CodeIgniter\Router\CustomerController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('/register', 'LoginController::registerIndex');
$routes->get('/logout', 'LoginController::logout'); 


$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
});

$routes->group('customer', ['filter' => 'role:customer'], function ($routes) {
    $routes->get('dashboard', 'CustomerController::dashboard');
});


$routes->post('/api/login', 'LoginController::login');
$routes->post('/api/register', 'LoginController::register');
$routes->get('/api/users', 'AdminController::getUsers'); 
$routes->put('/api/users/(:num)', 'AdminController::updateUser/$1');  
$routes->get('/edit-profile/(:num)', 'AdminController::getUser/$1');
$routes->delete('/api/users/(:num)', 'AdminController::deleteUser/$1');
$routes->get('/api/user/education/(:num)', 'AdminController::getEducation/$1');
$routes->post('/api/user/education/save', 'AdminController::saveEducation'); 
$routes->get('/api/user/employment/(:num)', 'AdminController::getEmployment/$1');
$routes->post('/api/user/employment/save', 'AdminController::saveEmployment');
$routes->get('/view/(:num)', 'AdminController::view/$1');
$routes->post('/api/users/uploadImage/(:num)', 'AdminController::uploadImage/$1');







