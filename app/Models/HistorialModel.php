<?php
namespace App\Models;
use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    protected $allowedFields = ['accion', 'fecha_accion', 'id_ticket', 'id_usuario'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}
?>