<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta principal
$routes->get('/', 'Auth::login');

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================

// Registro
$routes->get('registro', 'Auth::registro');
$routes->post('auth/guardar', 'Auth::guardarUsuario');

// Autenticación
$routes->get('login', 'Auth::login');
$routes->post('autenticar', 'Auth::autenticar');

// Logout
$routes->get('logout', 'Auth::logout');


// ============================================
// RUTAS DE DASHBOARD SEGÚN ROL
// ============================================
$routes->get('cliente/dashboard', 'Cliente\Dashboard::index');
$routes->get('tecnico/dashboard', 'Tecnico\Dashboard::index');
$routes->get('admin/dashboard', 'Admin\Dashboard::index');

