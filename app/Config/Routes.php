<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('donate', 'Home::donate');

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('donations', 'Admin\Donations::index');
    $routes->get('donations/view/(:num)', 'Admin\Donations::view/$1');
    $routes->post('donations/update-status', 'Admin\Donations::updateStatus');
    $routes->post('donations/assign', 'Admin\Donations::assign');
    $routes->get('donations/export', 'Admin\Donations::export');
    $routes->get('inventory', 'Admin\Inventory::index');
    $routes->get('inventory/add', 'Admin\Inventory::add');
    $routes->post('inventory/add', 'Admin\Inventory::add');
    $routes->get('inventory/edit/(:num)', 'Admin\Inventory::edit/$1');
    $routes->post('inventory/edit/(:num)', 'Admin\Inventory::edit/$1');
    $routes->get('inventory/delete/(:num)', 'Admin\Inventory::delete/$1');
    $routes->get('pickups', 'Admin\Pickups::index');
    $routes->post('pickups/schedule', 'Admin\Pickups::schedule');
    $routes->get('recipients', 'Admin\Recipients::index');
    $routes->get('recipients/add', 'Admin\Recipients::add');
    $routes->post('recipients/add', 'Admin\Recipients::add');
    $routes->get('recipients/view/(:num)', 'Admin\Recipients::view/$1');
    $routes->get('recipients/edit/(:num)', 'Admin\Recipients::edit/$1');
    $routes->post('recipients/edit/(:num)', 'Admin\Recipients::edit/$1');
    $routes->get('recipients/add-distribution', 'Admin\Recipients::addDistribution');
    $routes->post('recipients/add-distribution', 'Admin\Recipients::addDistribution');
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/add', 'Admin\Users::add');
    $routes->post('users/add', 'Admin\Users::add');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
});

// Auth routes (not protected)
$routes->get('admin/login', 'Auth\Login::index');
$routes->post('admin/login/authenticate', 'Auth\Login::authenticate');
$routes->get('admin/logout', 'Auth\Login::logout');