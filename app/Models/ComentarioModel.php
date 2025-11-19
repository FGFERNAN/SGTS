<?php
namespace App\Models;
use CodeIgniter\Model;

class ComentarioModel extends Model
{
    protected $table = 'comentarios';
    protected $primaryKey = 'id_comentario';
    protected $allowedFields = ['mensaje', 'fecha_comentario', 'observaciones', 'id_ticket', 'id_usuario'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    public function obtenerObservaciones($id_ticket)
    {
        return $this->select('comentarios.*, CONCAT(usuarios.nombre, " ", usuarios.apellidos) AS nombre_usuario')
        ->join('usuarios','comentarios.id_usuario = usuarios.id_usuario')
        ->where('comentarios.observaciones', 'true')
        ->where('comentarios.id_ticket', $id_ticket)
        ->findAll();
    }

    public function obtenerComentarios($id_ticket)
    {
        return $this->select('comentarios.*, CONCAT(usuarios.nombre, " ", usuarios.apellidos) AS nombre_usuario')
        ->join('usuarios','comentarios.id_usuario = usuarios.id_usuario')
        ->where('comentarios.observaciones', 'false')
        ->where('comentarios.id_ticket', $id_ticket)
        ->findAll();
    }
}
?>