<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['id_usuario', 'nombre', 'apellidos', 'email', 'id_tipo_documento', 'password', 'id_rol', 'id_estado_usuario'];
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;

    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function obtenerUsuariosConDetalles()
    {
        return $this->select('usuarios.*, tipo_documento.nombre AS tipo_documento, roles.nombre AS rol, estados_usuario.nombre AS estado')
            ->join('tipo_documento', 'usuarios.id_tipo_documento = tipo_documento.id_tipo_documento')
            ->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->join('estados_usuario', 'usuarios.id_estado_usuario = estados_usuario.id_estado_usuario')
            ->findAll();
    }
}
