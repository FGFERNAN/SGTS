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
use CodeIgniter\HTTP\SiteURI;

class Tickets extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $usuarioModel = new UsuarioModel();
        $estadoModel = new EstadoModel();
        $data['estados'] = $estadoModel->findAll();
        $data['tickets'] = $ticketModel->obtenerTicketsPorAdmin();
        $data['tecnicos'] = $usuarioModel->obtenerTecnicos();
        return view('admin/tickets/index', $data);
    }

    public function asignarTecnico()
    {
        $ticketModel = new TicketModel();
        $historialModel = new HistorialModel();
        $notificacionModel =  new NotificacionModel();

        $id_tecnico = $this->request->getPost('id_usuario_tecnico');
        $id_ticket = $this->request->getPost('id_ticket');
        $id_estado_ticket = $this->request->getPost('id_estado_ticket');

        $datosActualizar = [
            'id_usuario_tecnico' => $id_tecnico,
            'id_estado_ticket' => $id_estado_ticket,
        ];

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

        return redirect()->to(site_url('admin/tickets'))->with('success', 'Técnico asignado correctamente al ticket.');
    }
}

?>