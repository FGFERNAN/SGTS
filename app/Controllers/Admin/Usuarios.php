<?php

namespace App\Controllers\Admin;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Controllers\BaseController;

class Usuarios extends BaseController
{
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $data['usuarios'] = $usuarioModel->obtenerUsuariosConDetalles();
        return view('admin/usuarios/index', $data);
    }

    public function crear()
    {
        $rolModel = new RolModel();
        $data['roles'] = $rolModel->findAll();
        return view('admin/usuarios/crear', $data);
    }

    public function guardar()
    {
        $usuarioModel = new UsuarioModel();

        // Reglas de validación
        $reglas = [
            'id_usuario' => 'required|min_length[6]|max_length[11]|numeric|is_unique[usuarios.id_usuario]',
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]',
            'apellidos' => 'required|alpha_space|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'id_rol' => 'required',
            'id_tipo_documento' => 'required|in_list[1,2,3]',
            'password' => 'required|min_length[6]|max_length[20]|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}$/]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'id_usuario' => [
                'is_unique' => 'El número de documento ya está registrado.',
                'numeric' => 'El número de documento debe ser numérico.',
                'min_length' => 'El número de documento debe tener al menos 6 caracteres.',
                'max_length' => 'El número de documento no debe exceder los 11 caracteres.',
                'required' => 'El número de documento es obligatorio.',
            ],
            'nombre' => [
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'apellidos' => [
                'alpha_space' => 'Los apellidos solo pueden contener letras y espacios.',
                'required' => 'Los apellidos son obligatorios.',
                'min_length' => 'Los apellidos deben tener al menos 3 caracteres.',
                'max_length' => 'Los apellidos no deben exceder los 50 caracteres.',
            ],
            'email' => [
                'is_unique' => 'El correo electrónico ya está registrado.',
                'valid_email' => 'Por favor ingresa un correo válido.',
                'required' => 'El correo electrónico es obligatorio.',
            ],
            'id_tipo_documento' => [
                'in_list' => 'El tipo de documento seleccionado no es válido.',
                'required' => 'El tipo de documento es obligatorio.',
            ],
            'id_rol' => [
                'required' => 'El rol es obligatorio.',
            ],
            'password' => [
                'regex_match' => 'La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                'required' => 'La contraseña es obligatoria.',
            ],
        ];

        // Validar Datos, pasando reglas y mensajes
        $validacion = $this->validate($reglas, $mensajes);

        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hash = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

        $datos = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email' => $this->request->getPost('email'),
            'id_tipo_documento' => $this->request->getPost('id_tipo_documento'),
            'password' => $hash,
            'id_rol' => $this->request->getPost('id_rol'),
            'id_estado_usuario' => 1, // Activo por defecto
        ];

        if ($usuarioModel->insert($datos)) {
            return redirect()->to('/admin/usuarios')->with('success', 'Usuario creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear el usuario.');
        }
    }

    public function editar($id_usuario)
    {
        $usuarioModel = new UsuarioModel();
        $rolModel = new RolModel();

        $data['usuario'] = $usuarioModel->find($id_usuario);
        $data['roles'] = $rolModel->findAll();

        // Manejar si el usuario no existe
        if (empty($data['usuario'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado: ' . $id_usuario);
        }

        return view('admin/usuarios/editar', $data);
    }

    public function actualizar($id_usuario)
    {
        $usuarioModel = new UsuarioModel();

        // Reglas de validación
        $reglas = [
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]',
            'apellidos' => 'required|alpha_space|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuarios.email,id_usuario,' . $id_usuario . ']',
            'id_rol' => 'required',
            'id_tipo_documento' => 'required|in_list[1,2,3]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'nombre' => [
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'apellidos' => [
                'alpha_space' => 'Los apellidos solo pueden contener letras y espacios.',
                'required' => 'Los apellidos son obligatorios.',
                'min_length' => 'Los apellidos deben tener al menos 3 caracteres.',
                'max_length' => 'Los apellidos no deben exceder los 50 caracteres.',
            ],
            'email' => [
                'is_unique' => 'El correo electrónico ya está registrado.',
                'valid_email' => 'Por favor ingresa un correo válido.',
                'required' => 'El correo electrónico es obligatorio.',
            ],
            'id_tipo_documento' => [
                'in_list' => 'El tipo de documento seleccionado no es válido.',
                'required' => 'El tipo de documento es obligatorio.',
            ],
            'id_rol' => [
                'required' => 'El rol es obligatorio.',
            ],
        ];

        // Validar Datos, pasando reglas y mensajes
        $validacion = $this->validate($reglas, $mensajes);

        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email' => $this->request->getPost('email'),
            'id_tipo_documento' => $this->request->getPost('id_tipo_documento'),
            'id_rol' => $this->request->getPost('id_rol'),
        ];

        if ($usuarioModel->update($id_usuario, $datos)) {
            return redirect()->to('/admin/usuarios')->with('success', 'Usuario actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el usuario.');
        }
    }

    public function eliminar($id_usuario)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id_usuario);

        if (empty($usuario)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado: ' . $id_usuario);
        }

        $nuevoEstado = ($usuario['id_estado_usuario'] == 1) ? 2 : 1; 
        
        $usuarioModel->update($id_usuario, ['id_estado_usuario' => $nuevoEstado]);

        $mensaje = ($nuevoEstado == 1) ? 'Usuario activado.' : 'Usuario inactivado.';

        return redirect()->to(site_url('admin/usuarios'))->with('success', $mensaje);
    }
}
