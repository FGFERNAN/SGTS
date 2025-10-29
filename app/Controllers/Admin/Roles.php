<?php

namespace App\Controllers\Admin;

use App\Models\RolModel;
use App\Controllers\BaseController;

class Roles extends BaseController
{
    public function index()
    {
        $rolModel = new RolModel();
        $data['roles'] = $rolModel->findAll();
        return view('admin/roles/index', $data);
    }

    public function crear()
    {
        return view('admin/roles/crear');
    }

    public function guardar()
    {
        $rolModel = new RolModel();

        // Reglas de validación
        $reglas = [
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]|is_unique[roles.nombre]',
            'descripcion' => 'required|min_length[5]|max_length[255]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'nombre' => [
                'is_unique' => 'El nombre del rol ya está registrado.',
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 5 caracteres.',
                'max_length' => 'La descripción no debe exceder los 255 caracteres.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Guardar el nuevo rol
        $rolModel->save([
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

        return redirect()->to(site_url('admin/roles'))->with('success', 'Rol creado exitosamente.');
    }

    public function editar($id_rol)
    {
        $rolModel = new RolModel();
        $data['rol'] = $rolModel->find($id_rol);

        if (!$data['rol']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rol no encontrado');
        }

        return view('admin/roles/editar', $data);
    }

    public function actualizar($id_rol)
    {
        $rolModel = new RolModel();

        // Reglas de validación
        $reglas = [
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]|is_unique[roles.nombre,id_rol,' . $id_rol . ']',
            'descripcion' => 'required|min_length[5]|max_length[255]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'nombre' => [
                'is_unique' => 'El nombre del rol ya está registrado.',
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 5 caracteres.',
                'max_length' => 'La descripción no debe exceder los 255 caracteres.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Actualizar el rol
        $rolModel->update($id_rol, [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

        return redirect()->to(site_url('admin/roles'))->with('success', 'Rol actualizado exitosamente.');
    }
}
