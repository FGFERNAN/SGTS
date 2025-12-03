<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\UsuarioModel;
use App\Models\CategoriaModel;
use App\Models\PrioridadModel;
use App\Models\EstadoModel;
use App\Models\HistorialModel;
use App\Models\NotificacionModel;
use App\Models\ComentarioModel;

class Tickets extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $usuarioModel = new UsuarioModel();
        $estadoModel = new EstadoModel();
        $categoriaModel = new CategoriaModel();

        // 1. Capturar los filtros de la URL (GET)
        $filtros = [
            'id_tecnico'   => $this->request->getGet('id_tecnico'),
            'id_estado'    => $this->request->getGet('id_estado'),
            'id_categoria' => $this->request->getGet('id_categoria'),
            'fecha_inicio' => $this->request->getGet('fecha_inicio'),
            'fecha_fin'    => $this->request->getGet('fecha_fin'),
        ];

        // 2. Obtener los tickets aplicando los filtros
        $tickets = $ticketModel->filtrarTickets($filtros);

        // 3. Calcular Estadísticas Rápidas (Cards) sobre el resultado filtrado
        // Esto es un "plus" visual para tu reporte
        $totalTickets = count($tickets);
        $abiertos = 0;
        $cerrados = 0;
        $resueltos = 0;

        foreach ($tickets as $t) {
            // Asumiendo que 'Cerrado' o 'Resuelto' tienen IDs específicos o nombres
            // Ajusta esta lógica según tus IDs de estado reales
            if ($t['id_estado_ticket'] == 1 || $t['id_estado_ticket'] == 2) {
                $abiertos++;
            } elseif ($t['id_estado_ticket'] == 3) {
                $resueltos++;
            } else {
                $cerrados++;
            }
        }

        // 4. Preparar datos para la vista (Selects y Resultados)
        $data = [
            'tickets'      => $tickets,
            'filtros'      => $filtros, // Para mantener los inputs llenos después de filtrar

            // Datos para llenar los selects del filtro
            'tecnicos'     => $usuarioModel->obtenerTecnicos(),
            'estados'      => $estadoModel->findAll(),
            'estados_modal' => $estadoModel->obtenerAbiertos(),
            'categorias'   => $categoriaModel->getAll(),

            // Datos para las Cards
            'stats' => [
                'total'    => $totalTickets,
                'abiertos' => $abiertos,
                'cerrados' => $cerrados,
                'resueltos' => $resueltos,
            ]
        ];
        return view('admin/tickets/index', $data);
    }

    public function resueltos()
    {
        $ticketModel = new TicketModel();
        $estadoModel = new EstadoModel();
        $usuarioModel = new UsuarioModel();
        $data['estados'] = $estadoModel->findAll();
        $data['tickets'] = $ticketModel->obtenerTicketsResueltosAdmin();
        $data['tecnicos'] = $usuarioModel->obtenerTecnicos();
        return view('admin/tickets/resueltos', $data);
    }

    public function obtenerObservaciones($id_ticket)
    {
        $comentarioModel = new ComentarioModel();

        $observaciones = $comentarioModel->obtenerObservaciones($id_ticket);

        return $this->response->setJSON($observaciones);
    }

    public function asignarTecnico()
    {
        $ticketModel = new TicketModel();
        $historialModel = new HistorialModel();
        $notificacionModel =  new NotificacionModel();
        $db = \Config\Database::connect();

        $id_tecnico = $this->request->getPost('id_usuario_tecnico');
        $id_ticket = $this->request->getPost('id_ticket');
        $id_estado_ticket = $this->request->getPost('id_estado_ticket');

        // 2) Recuperar ticket actual
        $ticket = $ticketModel->find($id_ticket);
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket no encontrado.');
        }

        $tecnico_actual = ($ticket['id_usuario_tecnico'] === '' ? null : $ticket['id_usuario_tecnico']);
        $estado_actual  = $ticket['id_estado_ticket'];

        // 3) Detectar cambios reales
        $tecnico_cambiado = ($id_tecnico !== null) && ($id_tecnico !== $tecnico_actual);
        $estado_cambiado  = ($id_estado_ticket !== null) && ($id_estado_ticket !== $estado_actual);

        if (!$tecnico_cambiado && !$estado_cambiado) {
            // nothing to do
            return redirect()->back()->with('info', 'No hubo cambios para actualizar.');
        }

        // 4) Preparar datos de actualización sólo con los campos que cambiaron
        $datosActualizar = [];
        if ($tecnico_cambiado) {
            $datosActualizar['id_usuario_tecnico'] = $id_tecnico;
        }
        if ($estado_cambiado) {
            $datosActualizar['id_estado_ticket'] = $id_estado_ticket;
        }

        // 5) Ejecutar dentro de transacción
        $db->transStart();

        $ticketModel->update($id_ticket, $datosActualizar);

        $actorId = session()->get('id_usuario');

        // 6) Notificaciones y historial según cambio
        if ($tecnico_cambiado) {
            // Notificar al nuevo técnico (si no es null)
            if (!empty($id_tecnico)) {
                $notificacionModel->insert([
                    'id_usuario_destino' => $id_tecnico,
                    'titulo' => 'Ticket asignado',
                    'mensaje' => 'Se le ha asignado el ticket #' . $id_ticket . '.',
                    'enlace' => site_url('tecnico/dashboard'),
                    'leido' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Opcional: notificar al técnico anterior sobre la reasignación
            if (!empty($tecnico_actual) && ($tecnico_actual !== $id_tecnico)) {
                $notificacionModel->insert([
                    'id_usuario_destino' => $tecnico_actual,
                    'titulo' => 'Ticket reasignado',
                    'mensaje' => "El ticket #{$id_ticket} fue reasignado a otro técnico.",
                    'enlace' => site_url('tecnico/dashboard'),
                    'leido' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Historial: asignación
            $historialModel->insert([
                'accion' => 'Asignación de Técnico',
                'fecha_accion' => date('Y-m-d H:i:s'),
                'id_ticket' => $id_ticket,
                'id_usuario' => $actorId,
            ]);
        }

        if ($estado_cambiado) {
            // Notificar al cliente (propietario del ticket) sobre cambio de estado
            $clienteId = $ticket['id_usuario_cliente'] ?? null; // ajusta según tu columna
            if (!empty($clienteId)) {
                $notificacionModel->insert([
                    'id_usuario_destino' => $clienteId,
                    'titulo' => 'Cambio de estado en tu ticket',
                    'mensaje' => "El estado del ticket #{$id_ticket} ha cambiado.",
                    'enlace' => site_url("cliente/dashboard"),
                    'leido' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Historial: cambio de estado
            $historialModel->insert([
                'accion' => 'Cambio de Estado',
                'fecha_accion' => date('Y-m-d H:i:s'),
                'id_ticket' => $id_ticket,
                'id_usuario' => $actorId,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el ticket. Intenta de nuevo.');
        }

        // 7) Mensaje final según qué cambió
        if ($tecnico_cambiado && $estado_cambiado) {
            $msg = 'Técnico y estado actualizados correctamente.';
        } elseif ($tecnico_cambiado) {
            $msg = 'Técnico asignado correctamente.';
        } else {
            $msg = 'Estado actualizado correctamente.';
        }

        // Elegir URL de retorno según tu lógica
        return redirect()->to(site_url('admin/tickets'))->with('success', $msg);
    }
}
