<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->group('', ['namespace' => 'App\\Controllers\\Public'], static function ($routes) {
    $routes->get('/', 'HomeController::index');
});
