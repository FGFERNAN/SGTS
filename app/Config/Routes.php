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
$routes->get('logout', 'Auth::logout', ['filter' => 'auth']);

// Unauthorized
$routes->get('unauthorized', 'Auth::unauthorized');

// ============================================
// RUTAS DE DASHBOARD SEGÚN ROL
// ============================================
$routes->get('cliente/dashboard', 'Cliente\Dashboard::index');
$routes->get('tecnico/dashboard', 'Tecnico\Dashboard::index');


// ============================================
// RUTAS DE ADMINISTRACIÓN
// ============================================
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    // Rutas protegidas por el filtro AdminFilter
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('usuarios', 'Admin\Usuarios::index');
    $routes->get('usuarios/crear', 'Admin\Usuarios::crear');
    $routes->post('usuarios/guardar', 'Admin\Usuarios::guardar');
    $routes->get('usuarios/editar/(:segment)', 'Admin\Usuarios::editar/$1');
    $routes->post('usuarios/actualizar/(:segment)', 'Admin\Usuarios::actualizar/$1');
    $routes->get('usuarios/eliminar/(:segment)', 'Admin\Usuarios::eliminar/$1');
    $routes->get('roles', 'Admin\Roles::index');
    $routes->get('roles/crear', 'Admin\Roles::crear');
    $routes->post('roles/guardar', 'Admin\Roles::guardar');
    $routes->get('roles/editar/(:segment)', 'Admin\Roles::editar/$1');
    $routes->post('roles/actualizar/(:segment)', 'Admin\Roles::actualizar/$1');
});

// ============================================