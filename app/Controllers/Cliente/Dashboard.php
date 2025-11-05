<?php
namespace App\Controllers\Cliente;
use App\Controllers\BaseController;
use App\Models\TicketModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $id_cliente = session()->get('id_usuario');
        $data['tickets'] = $ticketModel->obtenerTicketsPorCliente($id_cliente);
        return view('cliente/dashboard', $data);
    }
}
?>