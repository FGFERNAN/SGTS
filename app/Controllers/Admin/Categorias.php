<?php
namespace App\Controllers\Admin;

use App\Models\CategoriaModel;
use App\Controllers\BaseController;

class Categorias extends BaseController
{
    public function index()
    {
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->obtenerCategoriasConDetalles();
        return view('admin/categorias/index', $data);
    }

    public function crear()
    {
        return view('admin/categorias/crear');
    }

    public function guardar()
    {
        $categoriaModel = new CategoriaModel();

        // Reglas de validación
        $reglas = [
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]|is_unique[categorias.nombre]',
            'descripcion' => 'permit_empty|max_length[500]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'nombre' => [
                'is_unique' => 'El nombre de la categoría ya está registrado.',
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'descripcion' => [
                'max_length' => 'La descripción no debe exceder los 500 caracteres.',
            ],
        ];

        $validacion = $this->validate($reglas, $mensajes);
        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Guardar la categoría
        $categoriaModel->save([
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'id_estado_categoria' => 1, // Activo por defecto
        ]);

        return redirect()->to('/admin/categorias')->with('success', 'Categoría creada exitosamente.');
    }

    public function editar($id_categoria) {
        $categoriaModel = new CategoriaModel();
        $data['categoria'] = $categoriaModel->find($id_categoria);

        // Manejar si el usuario no existe
        if (empty($data['categoria'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado: ' . $id_categoria);
        }
        return view('admin/categorias/editar', $data);
    }

    public function actualizar($id_categoria) {
        $categoriaModel = new CategoriaModel();

        // Reglas de validación
        $reglas = [
            'nombre' => 'required|alpha_space|min_length[3]|max_length[50]|is_unique[categorias.nombre,id_categoria,' . $id_categoria . ']',
            'descripcion' => 'permit_empty|max_length[500]',
        ];

        // Mensajes de error personalizados
        $mensajes = [
            'nombre' => [
                'is_unique' => 'El nombre de la categoría ya está registrado.',
                'alpha_space' => 'El nombre solo puede contener letras y espacios.',
                'required' => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 50 caracteres.',
            ],
            'descripcion' => [
                'max_length' => 'La descripción no debe exceder los 500 caracteres.',
            ],
        ];

        $validacion = $this->validate($reglas, $mensajes);
        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Actualizar la categoría
        $categoriaModel->update($id_categoria, [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

        return redirect()->to('/admin/categorias')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function eliminar($id_categoria) {
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($id_categoria);

        if(empty($categoria)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Categoría no encontrada: ' . $id_categoria);
        }

        $nuevoEstado = $categoria['id_estado_categoria'] == 1 ? 2 : 1; // Alternar entre activo (1) e inactivo (2)
        $categoriaModel->update($id_categoria, ['id_estado_categoria' => $nuevoEstado]);
        return redirect()->to(site_url('admin/categorias'))->with('success', 'Estado de la categoría actualizado exitosamente.');
    }
}

?>