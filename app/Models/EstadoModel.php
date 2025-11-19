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
}
?>