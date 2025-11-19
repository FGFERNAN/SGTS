<?php
namespace App\Controllers\Tecnico;
use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CategoriaModel;
use App\Models\PrioridadModel;
use App\Models\EstadoModel;
use App\Models\ComentarioModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $estadoTicketModel = new EstadoModel();
        $id_tecnico = session()->get('id_usuario');
        $data['estados'] = $estadoTicketModel->findAll();
        $data['tickets'] = $ticketModel->obtenerTicketsPorTecnico($id_tecnico);
        return view('tecnico/dashboard', $data);
    }
}
?>