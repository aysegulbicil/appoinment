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
$routes->get('verify-email', 'AuthController::verifyEmail');
$routes->post('verify-email/process', 'AuthController::attemptVerifyEmail');
$routes->post('verify-email/resend', 'AuthController::resendVerificationCode');
$routes->get('logout', 'AuthController::logout');

$routes->get('/', 'Public\\LandingController::index');
$routes->get('businesses', 'Public\\BusinessController::index');
$routes->post('businesses/(:num)/appointments', 'Public\\BusinessController::storeAppointment/$1');
$routes->get('businesses/(:segment)/(:segment)', 'Public\\BusinessController::page/$1/$2');
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
    $routes->get('web', 'BusinessWebController::index');
    $routes->get('businesses/(:num)/web-pages', 'BusinessWebPageController::index/$1');
    $routes->get('businesses/(:num)/web-pages/create', 'BusinessWebPageController::create/$1');
    $routes->post('businesses/(:num)/web-pages/store', 'BusinessWebPageController::store/$1');
    $routes->get('businesses/(:num)/web-pages/(:num)/edit', 'BusinessWebPageController::edit/$1/$2');
    $routes->post('businesses/(:num)/web-pages/(:num)/update', 'BusinessWebPageController::update/$1/$2');
    $routes->post('businesses/(:num)/web-pages/(:num)/delete', 'BusinessWebPageController::delete/$1/$2');
    $routes->post('businesses/(:num)/web-pages/(:num)/toggle-status', 'BusinessWebPageController::toggleStatus/$1/$2');
    $routes->post('businesses/(:num)/web-pages/(:num)/toggle-menu', 'BusinessWebPageController::toggleMenu/$1/$2');
    $routes->post('businesses/(:num)/web-pages/reorder', 'BusinessWebPageController::reorder/$1');
    $routes->get('businesses/(:num)/web-settings', 'BusinessWebSettingController::index/$1');
    $routes->get('businesses/(:num)/web-settings/general', 'BusinessWebSettingController::general/$1');
    $routes->get('businesses/(:num)/web-settings/menu', 'BusinessWebSettingController::menu/$1');
    $routes->get('businesses/(:num)/web-settings/seo', 'BusinessWebSettingController::seo/$1');
    $routes->post('businesses/(:num)/web-settings/general', 'BusinessWebSettingController::updateGeneral/$1');
    $routes->post('businesses/(:num)/web-settings/menu', 'BusinessWebSettingController::updateMenu/$1');
    $routes->post('businesses/(:num)/web-settings/seo', 'BusinessWebSettingController::updateSeo/$1');
    $routes->get('services', 'ServiceController::index');
    $routes->post('services/store', 'ServiceController::store');
    $routes->post('services/(:num)/update', 'ServiceController::update/$1');
    $routes->post('services/(:num)/toggle-status', 'ServiceController::toggleStatus/$1');
    $routes->get('employees', 'EmployeeController::index');
    $routes->post('employees/store', 'EmployeeController::store');
    $routes->post('employees/(:num)/update', 'EmployeeController::update/$1');
    $routes->post('employees/(:num)/toggle-status', 'EmployeeController::toggleStatus/$1');
    $routes->get('appointments', 'AppointmentController::index');
    $routes->post('appointments/(:num)/update', 'AppointmentController::update/$1');
    $routes->get('settings', 'SectionController::show/settings');
});

$routes->group('', ['namespace' => 'App\\Controllers\\Dashboard', 'filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'BusinessController::index');
    $routes->get('business', 'BusinessController::legacyRedirect');
    $routes->post('business/save', 'BusinessController::store');
    $routes->get('services', 'ServiceController::index');
    $routes->post('services/store', 'ServiceController::store');
    $routes->post('services/(:num)/update', 'ServiceController::update/$1');
    $routes->post('services/(:num)/toggle-status', 'ServiceController::toggleStatus/$1');
    $routes->get('employees', 'EmployeeController::index');
    $routes->post('employees/store', 'EmployeeController::store');
    $routes->post('employees/(:num)/update', 'EmployeeController::update/$1');
    $routes->post('employees/(:num)/toggle-status', 'EmployeeController::toggleStatus/$1');
    $routes->get('appointments', 'AppointmentController::index');
    $routes->post('appointments/(:num)/update', 'AppointmentController::update/$1');
    $routes->get('settings', 'SectionController::show/settings');
});
