<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CategoriaModel;
use App\Models\PrioridadModel;
use App\Models\EstadoTicketModel;
use App\Models\ComentarioModel;

class Tickets extends BaseController
{
    public function obtenerComentarios($id_ticket)
    {
        $comentarioModel = new ComentarioModel();

        $comentarios = $comentarioModel->obtenerComentarios($id_ticket);

        return $this->response->setJSON($comentarios);
    }

    public function crearTicket()
    {
        $categoriaModel = new CategoriaModel();
        $prioridadModel = new PrioridadModel();
        $data['categorias'] = $categoriaModel->getAll();
        $data['prioridades'] = $prioridadModel->findAll();
        return view('cliente/tickets/crear', $data);
    }

    public function guardarTicket()
    {
        $ticketModel = new TicketModel();

        // Reglas de validación
        $reglas = [
            'asunto' => 'required|alpha_numeric_space|min_length[5]|max_length[100]',
            'descripcion' => 'required|min_length[10]|max_length[1000]',
            'id_categoria' => 'required',
            'id_prioridad_ticket' => 'required',
        ];

        $mensajes = [
            'asunto' => [
                'required' => 'El asunto es obligatorio.',
                'alpha_numeric_space' => 'El asunto solo puede contener letras, números y espacios.',
                'min_length' => 'El asunto debe tener al menos 5 caracteres.',
                'max_length' => 'El asunto no debe exceder los 100 caracteres.',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 10 caracteres.',
                'max_length' => 'La descripción no debe exceder los 1000 caracteres.',
            ],
            'id_categoria' => [
                'required' => 'La categoría es obligatoria.',
            ],
            'id_prioridad_ticket' => [
                'required' => 'La prioridad es obligatoria.',
            ],
        ];

        $validacion = $this->validate($reglas, $mensajes);

        if (!$validacion) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datosTicket = [
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'id_usuario_cliente' => session()->get('id_usuario'),
            'id_categoria' => $this->request->getPost('id_categoria'),
            'id_prioridad_ticket' => $this->request->getPost('id_prioridad_ticket'),
            'id_estado_ticket' => 1, // Estado inicial: Abierto
        ];

        if($ticketModel->insert($datosTicket)) {
            return redirect()->to('/cliente/dashboard')->with('success', 'Ticket creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear el ticket.');
        }
    }

    public function detallesTicket($id_ticket)
    {
        $ticketModel = new TicketModel();
        $data['ticket_detalle'] = $ticketModel->find($id_ticket);

        // Manejar si el usuario no existe
        if (empty($data['ticket_detalle'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ticket no encontrado: ' . $id_ticket);
        }

        return view('cliente/dashboard', $data);
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
        return redirect()->to(site_url('cliente/dashboard'))->with('success', 'Comentario Exitoso.');
    }
}
