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

// Notificaciones
$routes->get('notificaciones/leer/(:segment)', 'Notificacion::leer/$1');

// ============================================
// RUTAS DE DASHBOARD SEGÚN ROL
// ============================================
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
    $routes->get('categorias', 'Admin\Categorias::index');
    $routes->get('categorias/crear', 'Admin\Categorias::crear');
    $routes->post('categorias/guardar', 'Admin\Categorias::guardar');
    $routes->get('categorias/editar/(:segment)', 'Admin\Categorias::editar/$1');
    $routes->post('categorias/actualizar/(:segment)', 'Admin\Categorias::actualizar/$1');
    $routes->get('categorias/eliminar/(:segment)', 'Admin\Categorias::eliminar/$1');
    $routes->get('tickets', 'Admin\Tickets::index');
    $routes->post('tickets/asignarTecnico', 'Admin\Tickets::asignarTecnico');
});

// ============================================

// RUTAS DE CLIENTE
// ============================================
$routes->group('cliente', ['filter' => 'role:3'], function ($routes) {
    // Rutas protegidas por el filtro ClienteFilter
    $routes->get('dashboard', 'Cliente\Dashboard::index');
    $routes->get('tickets/obtener-comentarios/(:segment)', 'Cliente\Tickets::obtenerComentarios/$1');
    $routes->get('tickets/crear', 'Cliente\Tickets::crearTicket');
    $routes->post('tickets/guardar', 'Cliente\Tickets::guardarTicket');
    $routes->get('tickets/detalles/(:segment)', 'Cliente\Tickets::detallesTicket/$1');
    $routes->post('tickets/comentar', 'Cliente\Tickets::comentar');
});

// ============================================
// RUTAS DE TÉCNICO
// ============================================
$routes->group('tecnico', ['filter' => 'role:2'], function ($routes) {
    // Rutas protegidas por el filtro TecnicoFilter
    $routes->get('dashboard', 'Tecnico\Dashboard::index');
    $routes->get('tickets/obtener-observaciones/(:segment)', 'Tecnico\Tickets::obtenerObservaciones/$1');
    $routes->get('tickets/obtener-comentarios/(:segment)', 'Tecnico\Tickets::obtenerComentarios/$1');
    $routes->post('tickets/registrar-avances', 'Tecnico\Tickets::registrarAvances');
    $routes->post('tickets/comentar', 'Tecnico\Tickets::comentar');
});