<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function registro()
    {
        return view('auth/register');
    }

    public function login()
    {
        // Si ya está logueado, redirigir al dashboard
        if (session()->has('id_usuario')) {
            return $this->redirigirSegunRol();
        }
        return view('auth/login');
    }

    public function guardarUsuario()
    {
        $usuarioModel = new UsuarioModel();

        // Reglas de validación
        $reglas = [
            'id_usuario' => 'required|min_length[6]|max_length[10]|numeric|is_unique[usuarios.id_usuario]',
            'nombre' => 'required|min_length[3]|max_length[50]',
            'apellidos' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'id_tipo_documento' => 'required|in_list[1,2,3]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'matches[password]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'id_usuario' => [
                'is_unique' => 'El número de documento ya está registrado.',
            ],
            'email' => [
                'is_unique' => 'El correo electrónico ya está registrado.',
            ],
            'confirm_password' => [
                'matches' => 'Las contraseñas no coinciden.',
            ],
            'id_tipo_documento' => [
                'in_list' => 'El tipo de documento seleccionado no es válido.',
            ],
        ];

        // Validar Datos, pasando reglas y mensajes
        $validacion = $this->validate($reglas, $mensajes);

        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hash = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

        $data = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email' => $this->request->getPost('email'),
            'id_tipo_documento' => $this->request->getPost('id_tipo_documento'),
            'password' => $hash,
            'id_rol' => 3, // Asignar rol cliente por defecto
            'id_estado_usuario' => 1 // Activo por defecto
        ];

        // Guardar en la base de datos
        if ($usuarioModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al registrar usuario.');
        }
    }

    public function autenticar()
    {
        $usuarioModel = new UsuarioModel();

        // Validar Datos
        $validacion = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $recordar = $this->request->getPost('recordar');

        $usuario = $usuarioModel->getByEmail($email);

        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->back()->withInput()->with('error_email', 'El usuario no existe.');
        }

        // Verificar si la cuenta está activa
        if ($usuario['id_estado_usuario'] != 1) {
            return redirect()->back()->withInput()->with('error_state', 'Tu cuenta está inactiva. Contacta al administrador.');
        }

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Autenticación exitosa
            $this->crearSesion($usuario, $recordar);

            // Registrar el login en logs (opcional pero recomendado)
            log_message('info', 'Login exitoso - Usuario: ' . $email . ' - Rol: ' . $usuario['id_rol']);

            // Redirigir según el rol
            return $this->redirigirSegunRol();
        } else {
            // Fallo en la autenticación
            return redirect()->back()->withInput()->with('error_password', 'Contraseña incorrecta.');
        }
    }

    private function crearSesion($usuario, $recordar)
    {
        $sessionData = [
            'id_usuario' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'apellidos' => $usuario['apellidos'],
            'email' => $usuario['email'],
            'id_rol' => $usuario['id_rol'],
            'isLoggedIn' => true,
        ];

        session()->set($sessionData);

        if ($recordar) {
            // Configurar la sesión para que dure más tiempo
            session()->setTempdata('remember_me', true, 2592000); // 30 días
        }
    }

    private function redirigirSegunRol()
    {
        $rol = session()->get('id_rol');

        switch ($rol) {
            case 1:
                return redirect()->to('/admin/dashboard');
            case 2:
                return redirect()->to('/tecnico/dashboard');
            case 3:
                return redirect()->to('/cliente/dashboard');
            default:
                session()->destroy();
                return redirect()->to('/login')->with('error', 'Rol de usuario desconocido.');
        }
    }

    public function logout()
    {
        log_message('info', 'Logout - Usuario: ' . session()->get('id_usuario'));
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
