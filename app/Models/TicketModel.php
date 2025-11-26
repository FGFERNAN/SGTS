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

    public function obtenerTicketsAbiertosAdmin()
    {
        return $this->select('tickets.*, CONCAT(uc.nombre, " " , uc.apellidos) AS nombre_cliente, CONCAT(ut.nombre, " " , ut.apellidos) AS nombre_tecnico, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios AS uc', 'tickets.id_usuario_cliente = uc.id_usuario')
            ->join('usuarios AS ut', 'tickets.id_usuario_tecnico = ut.id_usuario', 'left')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket')
            ->findAll();
    }

    public function filtrarTickets($filtros = [])
    {
        // 1. Iniciamos la consulta base con los JOINs necesarios para mostrar nombres
        $builder = $this->select('tickets.*, CONCAT(uc.nombre, " " , uc.apellidos) AS nombre_cliente, CONCAT(ut.nombre, " " , ut.apellidos) AS nombre_tecnico, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios AS uc', 'tickets.id_usuario_cliente = uc.id_usuario')
            ->join('usuarios AS ut', 'tickets.id_usuario_tecnico = ut.id_usuario', 'left')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket');

        // 2. Aplicamos filtros condicionales (Solo si existen en el array)

        // Filtro por Técnico
        if (!empty($filtros['id_tecnico'])) {
            $builder->where('tickets.id_usuario_tecnico', $filtros['id_tecnico']);
        }

        // Filtro por Estado
        if (!empty($filtros['id_estado'])) {
            $builder->where('tickets.id_estado_ticket', $filtros['id_estado']);
        }

        // Filtro por Categoría
        if (!empty($filtros['id_categoria'])) {
            $builder->where('tickets.id_categoria', $filtros['id_categoria']);
        }

        // Filtro por Rango de Fechas (Fecha Creación)
        if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
            // Aseguramos incluir todo el día final (23:59:59)
            $builder->where("tickets.fecha_creacion >=", $filtros['fecha_inicio'] . ' 00:00:00');
            $builder->where("tickets.fecha_creacion <=", $filtros['fecha_fin'] . ' 23:59:59');
        }

        // 3. Ordenamos y devolvemos
        return $builder->orderBy('tickets.fecha_creacion', 'DESC')->findAll();
    }

    public function contarTicketsPorCampo(string $campo, string $alias = 'conteo')
    {
        return $this->select("{$campo}, COUNT(id_ticket) as {$alias}")
            ->groupBy($campo)
            ->findAll();
    }

    public function obtenerTicketsResueltosAdmin()
    {
        return $this->select('tickets.*, CONCAT(uc.nombre, " " , uc.apellidos) AS nombre_cliente, CONCAT(ut.nombre, " " , ut.apellidos) AS nombre_tecnico, categorias.nombre AS categoria, estados_tickets.nombre AS estado, prioridad_tickets.nombre AS prioridad')
            ->join('usuarios AS uc', 'tickets.id_usuario_cliente = uc.id_usuario')
            ->join('usuarios AS ut', 'tickets.id_usuario_tecnico = ut.id_usuario', 'left')
            ->join('categorias', 'tickets.id_categoria = categorias.id_categoria')
            ->join('estados_tickets', 'tickets.id_estado_ticket = estados_tickets.id_estado_ticket')
            ->join('prioridad_tickets', 'tickets.id_prioridad_ticket = prioridad_tickets.id_prioridad_ticket')
            ->where('tickets.id_estado_ticket =', 3) // Resueltos
            ->orWhere('tickets.id_estado_ticket =', 4) // Cerrados
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
