<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion', 'id_estado_categoria'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    public function obtenerCategoriasConDetalles()
    {
        return $this->select('categorias.*, estados_categorias.nombre AS estado')
            ->join('estados_categorias', 'categorias.id_estado_categoria = estados_categorias.id_estado_categoria')
            ->findAll();
    }

    public function getAll()
    {
        return $this->select('categorias.*')
            ->where('categorias.id_estado_categoria', 1) // Solo categorías activas
            ->findAll();
    }
}
