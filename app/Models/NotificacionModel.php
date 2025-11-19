<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    protected $allowedFields = ['id_usuario_destino', 'titulo', 'mensaje', 'enlace', 'leido', 'created_at'];
    protected $useTimestamps = false;
    protected $useAutoIncrement = true;

    public function obtenerNoLeidas($id_usuario)
    {
        return $this->where('id_usuario_destino', $id_usuario)
            ->where('leido', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
