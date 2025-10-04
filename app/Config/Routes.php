<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

$routes->get('/home', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login/do', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('register', 'Auth::register');
$routes->post('register/do', 'Auth::doRegister');

// Admin: CRUD Anggota DPR
$routes->get('anggota', 'AnggotaController::index');
$routes->get('anggota/create', 'AnggotaController::create');
$routes->post('anggota/store', 'AnggotaController::store');
$routes->get('anggota/edit/(:num)', 'AnggotaController::edit/$1');
$routes->post('anggota/update/(:num)', 'AnggotaController::update/$1');
$routes->get('anggota/delete/(:num)', 'AnggotaController::delete/$1');

// Admin: CRUD Komponen Gaji
$routes->get('komponen_gaji', 'KomponenGajiController::index');
$routes->get('komponen_gaji/create', 'KomponenGajiController::create');
$routes->post('komponen_gaji/store', 'KomponenGajiController::store');
$routes->get('komponen_gaji/edit/(:num)', 'KomponenGajiController::edit/$1');
$routes->post('komponen_gaji/update/(:num)', 'KomponenGajiController::update/$1');
$routes->get('komponen_gaji/delete/(:num)', 'KomponenGajiController::delete/$1');

// Admin: CRUD Penggajian
$routes->get('penggajian', 'PenggajianController::index');
$routes->get('penggajian/create', 'PenggajianController::create');
$routes->post('penggajian/store', 'PenggajianController::store');
$routes->get('penggajian/detail/(:num)/(:num)', 'PenggajianController::detail/$1/$2');
$routes->get('penggajian/edit/(:num)/(:num)', 'PenggajianController::edit/$1/$2');
$routes->post('penggajian/update/(:num)/(:num)', 'PenggajianController::update/$1/$2');
$routes->get('penggajian/delete/(:num)/(:num)', 'PenggajianController::delete/$1/$2');

// Public: Read Only
$routes->get('/public/anggota', 'PublicController::anggota');
$routes->get('/public/penggajian', 'PublicController::penggajian');
$routes->get('public/penggajian/detail/(:num)', 'PublicController::penggajianDetail/$1');

//$routes->get('/public/anggota', 'AnggotaController::publicIndex');