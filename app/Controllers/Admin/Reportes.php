<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\UsuarioModel;
use App\Models\CategoriaModel;
use App\Models\PrioridadModel;
use App\Models\EstadoModel;


use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportes extends BaseController
{
    public function index()
    {
        // 1. Obtener los nombres de los estados para mapear los IDs
        $estadoModel = new EstadoModel();
        $ticketModel = new TicketModel();
        $categoriaModel = new CategoriaModel();
        // Mapea ['id' => 1, 'nombre' => 'Abierto'] a [1 => 'Abierto']
        $mapaEstados = array_column($estadoModel->findAll(), 'nombre', 'id_estado_ticket');
        $mapaCategorias = array_column($categoriaModel->findAll(), 'nombre', 'id_categoria');

        // 2. Obtener los datos contados de la DB
        $ticketsPorEstado = $ticketModel->contarTicketsPorCampo('id_estado_ticket');
        $ticketsPorCategoria = $ticketModel->contarTicketsPorCampo('id_categoria');

        // 3. Estructurar los datos finales para Chart.js
        $datosGrafico1 = [
            'labels' => [], // Nombres de los estados
            'data' => [],   // Cantidad de tickets
            // Colores manuales que Chart.js usará
            'colores' => ['#dc3545', '#ffc107', '#198754', '#6c757d']
        ];

        $datosGrafico2 = [
            'labels' => [], // Nombres de las categorías
            'data' => [],   // Cantidad de tickets
            // Colores manuales que Chart.js usará
            'colores' => ['#0d6efd', '#6610f2', '#fd7e14', '#20c997', '#adb5bd']
        ];

        foreach ($ticketsPorEstado as $item) {
            $idEstado = $item['id_estado_ticket'];

            // Convertir el ID (1, 2, 3...) al Nombre ('Abierto', 'Cerrado'...)
            $nombreEstado = $mapaEstados[$idEstado] ?? 'Desconocido';

            $datosGrafico1['labels'][] = $nombreEstado;
            $datosGrafico1['data'][] = (int)$item['conteo'];
        }

        foreach ($ticketsPorCategoria as $item) {
            $idCategoria = $item['id_categoria'];

            // Convertir el ID (1, 2, 3...) al Nombre ('Redes', 'Software'...)
            $nombreCategoria = $mapaCategorias[$idCategoria] ?? 'Desconocido';

            $datosGrafico2['labels'][] = $nombreCategoria;
            $datosGrafico2['data'][] = (int)$item['conteo'];
        }
        

        // 4. Enviar a la vista codificado en JSON
        $data['grafico1Json'] = json_encode($datosGrafico1);
        $data['grafico2Json'] = json_encode($datosGrafico2);

        
        return view('admin/reportes/index', $data);
    }

    /**
     * Genera y descarga el reporte en PDF
     */
    public function exportarPdf()
    {
        $ticketModel = new TicketModel();

        // 1. REUTILIZAMOS LA LÓGICA DE FILTROS
        // Capturamos exactamente los mismos parámetros que en el index
        $filtros = [
            'id_tecnico'   => $this->request->getGet('id_tecnico'),
            'id_estado'    => $this->request->getGet('id_estado'),
            'id_categoria' => $this->request->getGet('id_categoria'),
            'fecha_inicio' => $this->request->getGet('fecha_inicio'),
            'fecha_fin'    => $this->request->getGet('fecha_fin'),
        ];

        // 2. Obtenemos los datos filtrados
        $tickets = $ticketModel->filtrarTickets($filtros);

        // 3. Preparamos el HTML para el PDF
        // No usamos la vista 'index' porque esa tiene menús y botones.
        // Creamos una vista limpia específica para impresión.
        $html = view('admin/reportes/pdf_template', [
            'tickets' => $tickets,
            'filtros' => $filtros,
            'fecha_generacion' => date('d/m/Y H:i:s')
        ]);

        // 4. Configuración de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Para permitir imágenes/css externos si los usas
        $dompdf = new Dompdf($options);

        // Cargar el HTML
        $dompdf->loadHtml($html);

        // Configurar papel (A4 Horizontal suele ser mejor para tablas anchas)
        $dompdf->setPaper('A4', 'landscape');

        // Renderizar
        $dompdf->render();

        // 5. Forzar descarga
        $dompdf->stream("Reporte_Tickets_" . date('Ymd_His') . ".pdf", ["Attachment" => true]);
    }

    /**
     * Genera y descarga el reporte en Excel (.xlsx)
     */
    public function exportarExcel()
    {
        $ticketModel = new TicketModel();

        // 1. REUTILIZAMOS LA LÓGICA DE FILTROS
        $filtros = [
            'id_tecnico'   => $this->request->getGet('id_tecnico'),
            'id_estado'    => $this->request->getGet('id_estado'),
            'id_categoria' => $this->request->getGet('id_categoria'),
            'fecha_inicio' => $this->request->getGet('fecha_inicio'),
            'fecha_fin'    => $this->request->getGet('fecha_fin'),
        ];

        $tickets = $ticketModel->filtrarTickets($filtros);

        // 2. Crear documento Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Definir Cabeceras
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Asunto');
        $sheet->setCellValue('C1', 'Cliente');
        $sheet->setCellValue('D1', 'Técnico Asignado');
        $sheet->setCellValue('E1', 'Categoría');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('G1', 'Fecha Creación');

        // Estilo básico para cabecera (Negrita)
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // 4. Rellenar datos
        $fila = 2; // Empezamos en la fila 2
        foreach ($tickets as $t) {
            $sheet->setCellValue('A' . $fila, $t['id_ticket']);
            $sheet->setCellValue('B' . $fila, $t['asunto']);
            $sheet->setCellValue('C' . $fila, $t['nombre_cliente']);
            $sheet->setCellValue('D' . $fila, !empty($t['nombre_tecnico']) ? $t['nombre_tecnico'] : 'Sin asignar');
            $sheet->setCellValue('E' . $fila, $t['categoria']);
            $sheet->setCellValue('F' . $fila, $t['estado']);
            $sheet->setCellValue('G' . $fila, $t['fecha_creacion']); // Podrías formatear la fecha si quieres
            $fila++;
        }

        // 5. Auto-ajustar ancho de columnas
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 6. Configurar cabeceras HTTP para descarga
        $filename = "Reporte_Tickets_" . date('Ymd_His') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
