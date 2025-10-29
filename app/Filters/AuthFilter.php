<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el usuario está logueado
        if (!session()->has('isLoggedIn') || !session()->get('isLoggedIn')) {
            // Redirigir al formulario de login si no está logueado
            return redirect()->to('/login')->with('error', 'Por favor, inicia sesión para continuar.');
        }

        if(!session()->has('id_usuario') || !session()->has('id_rol')) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesión inválida. Por favor, inicia sesión nuevamente.');
        }

        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->find(session()->get('id_usuario'));

        if (!$usuario) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Usuario no encontrado. Por favor, inicia sesión nuevamente.');
        }

        // Verificar si la cuenta está activa
        if ($usuario['id_estado_usuario'] != 1) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica después de la solicitud en este filtro
    }
}

?>