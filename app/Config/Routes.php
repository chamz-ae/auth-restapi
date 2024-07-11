<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// File: app/Config/Routes.php
$routes->post('register', 'AuthController::register');
$routes->post('login', 'AuthController::login');