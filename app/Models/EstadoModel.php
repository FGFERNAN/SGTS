<?php
namespace App\Models;
use CodeIgniter\Model;

class EstadoModel extends Model
{
    protected $table = 'estados_tickets';
    protected $primaryKey = 'id_estado_ticket';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    public function obtenerAbiertos()
    {
        return $this->where('id_estado_ticket', 1)
        ->orWhere('id_estado_ticket', 2)
        ->findAll();
    }

    public function obtenerResueltos()
    {
        return $this->where('id_estado_ticket', 3)
        ->orWhere('id_estado_ticket', 4)
        ->findAll();
    }
}
?>