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
            } elseif($t['id_estado_ticket'] == 3) {
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
            'estados_modal'=> $estadoModel->obtenerAbiertos(),
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

        $id_tecnico = $this->request->getPost('id_usuario_tecnico');
        $id_ticket = $this->request->getPost('id_ticket');
        $id_estado_ticket = $this->request->getPost('id_estado_ticket');

        if (empty($id_tecnico)) {
            $datosActualizar = [
                'id_estado_ticket' => $id_estado_ticket,
            ];
            $url = 'admin/tickets/resueltos';
        } else {
            $datosActualizar = [
                'id_usuario_tecnico' => $id_tecnico,
                'id_estado_ticket' => $id_estado_ticket,
            ];
            $url = 'admin/tickets';
        }

        $ticketModel->update($id_ticket, $datosActualizar);

        $notificacionModel->insert([
            'id_usuario_destino' => $id_tecnico,
            'titulo' => 'Ticket Actualizado',
            'mensaje' => 'Se ha actualizado el ticket #' . $id_ticket . '. Revisa los detalles.',
            'enlace' => site_url('tecnico/dashboard'),
            'leido' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $historialData = [
            'accion' => 'Actualización Ticket',
            'fecha_accion' => date('Y-m-d H:i:s'),
            'id_ticket' => $id_ticket,
            'id_usuario' => session()->get('id_usuario'),
        ];
        $historialModel->insert($historialData);

        return redirect()->to(site_url($url))->with('success', 'Técnico asignado correctamente al ticket.');
    }
}
