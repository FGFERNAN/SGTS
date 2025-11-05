<?php
namespace App\Models;
use CodeIgniter\Model;

class PrioridadModel extends Model
{
    protected $table = 'prioridad_tickets';
    protected $primaryKey = 'id_prioridad_ticket';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}
?>