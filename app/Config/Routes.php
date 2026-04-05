<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::attemptRegister');
$routes->post('login/process', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('/', 'Public\\LandingController::index');

$routes->group('', ['namespace' => 'App\\Controllers\\Dashboard', 'filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'SectionController::show/business');
    $routes->get('business', 'SectionController::show/business');
    $routes->get('services', 'SectionController::show/services');
    $routes->get('employees', 'SectionController::show/employees');
    $routes->get('availabilities', 'SectionController::show/availabilities');
    $routes->get('appointments', 'SectionController::show/appointments');
    $routes->get('settings', 'SectionController::show/settings');
});
