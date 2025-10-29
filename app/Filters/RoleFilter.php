<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty($arguments)) {
            return;
        }
        // Verificar si el usuario tiene el rol adecuado
        if (session()->has('id_rol')) {
            $userRole = session()->get('id_rol');
            $allowedRoles = is_array($arguments) ? $arguments : [$arguments];

            if (!in_array($userRole, $allowedRoles)) {
                // Redirigir si el rol no es permitido
                return redirect()->to('/unauthorized')->with('error', 'No tienes permiso para acceder a esta página.');
            }
        } else {
            // Si no hay rol en sesión, redirigir al login
            return redirect()->to('/login')->with('error', 'Por favor, inicia sesión para continuar.');
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica después de la solicitud en este filtro
    }
}
