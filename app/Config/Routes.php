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


// ============================================
// RUTAS DE ADMINISTRACIÓN
// ============================================
$routes->get('admin/usuarios', 'Admin\Usuarios::index');
$routes->get('admin/usuarios/crear', 'Admin\Usuarios::crear');
$routes->post('admin/usuarios/guardar', 'Admin\Usuarios::guardar');
$routes->get('admin/usuarios/editar/(:segment)', 'Admin\Usuarios::editar/$1');
$routes->post('admin/usuarios/actualizar/(:segment)', 'Admin\Usuarios::actualizar/$1');
$routes->get('admin/usuarios/eliminar/(:segment)', 'Admin\Usuarios::eliminar/$1');