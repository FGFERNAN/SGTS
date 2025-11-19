<?php
namespace App\Models;
use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';
    protected $allowedFields = ['asunto', 'descripcion', 'id_usuario_cliente', 'id_usuario_tecnico', 'id_categoria', 'id_estado_ticket', 'id_prioridad_ticket'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    public function obtenerTicketsPorCliente($id_cliente)
    {
        return $this->select('tickets.*, CONCAT(usuarios.nombre, " " , usuarios.apellidos) AS nombre_tecnico, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios', 'tickets.id_usuario_tecnico = usuarios.id_usuario', 'left')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket')
            ->where('tickets.id_usuario_cliente', $id_cliente)
            ->findAll();
    }

    public function obtenerTicketsPorAdmin()
    {
        return $this->select('tickets.*, CONCAT(uc.nombre, " " , uc.apellidos) AS nombre_cliente, CONCAT(ut.nombre, " " , ut.apellidos) AS nombre_tecnico, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios AS uc', 'tickets.id_usuario_cliente = uc.id_usuario')
            ->join('usuarios AS ut', 'tickets.id_usuario_tecnico = ut.id_usuario', 'left')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket')
            ->findAll();
    }

    public function obtenerTicketsPorTecnico($id_tecnico)
    {
        return $this->select('tickets.*, CONCAT(uc.nombre, " " , uc.apellidos) AS nombre_cliente, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios AS uc', 'tickets.id_usuario_cliente = uc.id_usuario')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket')
            ->where('tickets.id_usuario_tecnico', $id_tecnico)
            ->findAll();
    }
}

?>