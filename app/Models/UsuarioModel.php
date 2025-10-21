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
}

?>