<?php
namespace App\Models;
use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}


?>