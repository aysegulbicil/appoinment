<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->get('packages/select/(:segment)', 'AuthController::selectPackage/$1');
$routes->post('register/process', 'AuthController::attemptRegister');
$routes->post('login/process', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('/', 'Public\\LandingController::index');
$routes->get('businesses', 'Public\\BusinessController::index');
$routes->post('businesses/(:num)/appointments', 'Public\\BusinessController::storeAppointment/$1');
$routes->get('businesses/(:segment)', 'Public\\BusinessController::show/$1');

$routes->group('dashboard', ['namespace' => 'App\\Controllers\\Dashboard', 'filter' => 'auth'], static function ($routes) {
    $routes->get('', 'BusinessController::index');
    $routes->get('businesses', 'BusinessController::index');
    $routes->get('businesses/create', 'BusinessController::create');
    $routes->post('businesses/store', 'BusinessController::store');
    $routes->get('businesses/(:num)', 'BusinessController::show/$1');
    $routes->post('businesses/(:num)/update', 'BusinessController::update/$1');
    $routes->post('businesses/(:num)/editor-image', 'BusinessController::uploadEditorImage/$1');
    $routes->post('businesses/(:num)/toggle-status', 'BusinessController::toggleStatus/$1');
    $routes->post('businesses/(:num)/services/store', 'BusinessController::storeService/$1');
    $routes->post('services/(:num)/update', 'BusinessController::updateService/$1');
    $routes->post('services/(:num)/toggle-status', 'BusinessController::toggleServiceStatus/$1');
    $routes->get('services', 'SectionController::show/services');
    $routes->get('employees', 'SectionController::show/employees');
    $routes->get('availabilities', 'SectionController::show/availabilities');
    $routes->get('appointments', 'AppointmentController::index');
    $routes->post('appointments/(:num)/update', 'AppointmentController::update/$1');
    $routes->get('settings', 'SectionController::show/settings');
});

$routes->group('', ['namespace' => 'App\\Controllers\\Dashboard', 'filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'BusinessController::index');
    $routes->get('business', 'BusinessController::legacyRedirect');
    $routes->post('business/save', 'BusinessController::store');
    $routes->get('services', 'SectionController::show/services');
    $routes->get('employees', 'SectionController::show/employees');
    $routes->get('availabilities', 'SectionController::show/availabilities');
    $routes->get('appointments', 'AppointmentController::index');
    $routes->post('appointments/(:num)/update', 'AppointmentController::update/$1');
    $routes->get('settings', 'SectionController::show/settings');
});
