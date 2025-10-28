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
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'id_usuario' => [
                'is_unique' => 'El número de documento ya está registrado.',
            ],
            'nombre' => [
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
            ],
            'apellidos' => [
                'alpha_space' => 'Los apellidos solo pueden contener letras y espacios.',
            ],
            'email' => [
                'is_unique' => 'El correo electrónico ya está registrado.',
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
            ],
            'apellidos' => [
                'alpha_space' => 'Los apellidos solo pueden contener letras y espacios.',
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

        return redirect()->back()->with('success', $mensaje);
    }
}
