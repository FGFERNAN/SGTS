<?php

namespace App\Controllers\Tecnico;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CategoriaModel;
use App\Models\PrioridadModel; 
use App\Models\EstadoTicketModel;
use App\Models\HistorialModel;
use App\Models\ComentarioModel;

class Tickets extends BaseController
{
    public function obtenerObservaciones($id_ticket)
    {
        $comentarioModel = new ComentarioModel();

        $observaciones = $comentarioModel->obtenerObservaciones($id_ticket);

        return $this->response->setJSON($observaciones);
    }

    public function obtenerComentarios($id_ticket)
    {
        $comentarioModel = new ComentarioModel();

        $comentarios = $comentarioModel->obtenerComentarios($id_ticket);

        return $this->response->setJSON($comentarios);
    }

    public function registrarAvances()
    {
        $ticketModel = new TicketModel();
        $historialModel = new HistorialModel();
        $comentarioModel =  new ComentarioModel();


        $id_ticket = $this->request->getPost('id_ticket');
        $id_estado_ticket = $this->request->getPost('id_estado_ticket');

        $datosActualizar = [
            'id_estado_ticket' => $id_estado_ticket,
        ];

        $ticketModel->update($id_ticket, $datosActualizar);

        $mensaje = $this->request->getPost('mensaje');

        if (!empty($mensaje) && trim($mensaje) !== '') {
            $comentarioData = [
                'mensaje' => $mensaje,
                'fecha_comentario' => date('Y-m-d H:i:s'),
                'observaciones' => 'true',
                'id_ticket' => $id_ticket,
                'id_usuario' => session()->get('id_usuario')
            ];
            $comentarioModel->insert($comentarioData);
        }

        $historialData = [
            'accion' => 'Cambio de Estado Ticket',
            'fecha_accion' => date('Y-m-d H:i:s'),
            'id_ticket' => $id_ticket,
            'id_usuario' => session()->get('id_usuario'),
        ];
        $historialModel->insert($historialData);

        return redirect()->to(site_url('tecnico/dashboard'))->with('success', 'Ticket Actualizado.');
    }

    public function comentar()
    {
        $comentarioModel = new ComentarioModel();

        $id_ticket = $this->request->getPost('id_ticket');

        $mensaje = $this->request->getPost('mensaje');

        if (!empty($mensaje) && trim($mensaje) !== '') {
            $comentarioData = [
                'mensaje' => $mensaje,
                'fecha_comentario' => date('Y-m-d H:i:s'),
                'observaciones' => 'false',
                'id_ticket' => $id_ticket,
                'id_usuario' => session()->get('id_usuario')
            ];
            $comentarioModel->insert($comentarioData);
        }
        return redirect()->to(site_url('tecnico/dashboard'))->with('success', 'Comentario Exitoso.');
    }
}
