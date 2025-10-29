<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar autenticación
        if (!session()->has('isLoggedIn') || !session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder al panel de administración.');
        }

        // Verificar si el usuario tiene rol de administrador (asumiendo id_rol = 1 es admin)
        if (session()->get('id_rol') != 1) {
            // Redirigir si no es administrador
            return redirect()->to('/unauthorized')->with('error', 'No tienes permiso para acceder a esta página.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica después de la solicitud en este filtro
    }
}
