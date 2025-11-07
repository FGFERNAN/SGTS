<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Dashboard Cliente - SGTS<?= $this->endSection() ?>

<?=$this->section('sidebar') ?>
    <?= $this->include('layouts/partials/cliente/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
    <?= $this->include('layouts/partials/cliente/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h2 class="mb-4">Dashboard Cliente</h2>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h3 class="card-title mb-0">Tickets</h3>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= site_url('cliente/tickets/crear') ?>" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border mb-0">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary text-center">Asunto</th>
                        <th class="bg-body-secondary">Fecha Creación</th>
                        <th class="bg-body-secondary text-center">Tecnico Asignado</th>
                        <th class="bg-body-secondary">Categoria</th>
                        <th class="bg-body-secondary">Estado</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <?php foreach ($tickets as $ticket): ?>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($ticket['asunto']) ?></div>
                            </td>
                            <td>
                                <div class="small text-body-secondary text-nowrap"><?= esc($ticket['fecha_creacion']) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($ticket['nombre_tecnico']) ? esc($ticket['nombre_tecnico']) : 'Sin técnico asignado' ?></div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <div class="text-nowrap small text-body-secondary ms-3"><?= esc($ticket['categoria']) ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-nowrap">
                                    <?php switch (esc($ticket['estado'])) {
                                        case 'Abierto':
                                            echo '<span class="text-success">' . esc($ticket['estado']) . '</span>';
                                            break;
                                        case 'En Proceso':
                                            echo '<span class="text-warning">' . esc($ticket['estado']) . '</span>';
                                            break;
                                        case 'Cerrado':
                                            echo '<span class="text-danger">' . esc($ticket['estado']) . '</span>';
                                            break;
                                        default:
                                            echo '<span>' . esc($ticket['estado']) . '</span>';
                                            break;
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-options') ?>"></use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <button class="dropdown-item btn-ver-detalles"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#modalDetallesTicket"
                                            data-asunto="<?= esc($ticket['asunto']) ?>"
                                            data-fecha-cierre="<?= esc($ticket['fecha_cierre']) ?>"
                                            data-descripcion="<?= esc($ticket['descripcion']) ?>"
                                            data-prioridad="<?= esc($ticket['prioridad']) ?>">
                                            Ver Detalles
                                        </button>
                                    </div>
                                </div>
                            </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="modal fade" id="modalDetallesTicket" tabindex="-1" aria-labelledby="modalDetallesTicketLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetallesTicketLabel">Detalles Ticket</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="modal-fecha-cierre" class="col-form-label">Fecha Cierre:</label>
                                    <div class="small text-body-secondary text-nowrap" id="modal-fecha-cierre"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="modal-descripcion" class="col-form-label">Descripción:</label>
                                    <textarea class="form-control" id="modal-descripcion" readonly disabled></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="modal-prioridad" class="col-form-label">Prioridad:</label>
                                    <div class="fw-semibold text-nowrap" id="modal-prioridad"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js_adicional') ?>
<script>
    // Espera a que todo el HTML esté cargado
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Selecciona el modal
        const modalDetalles = document.getElementById('modalDetallesTicket');
        
        // 2. Escucha el evento 'show.coreui.modal' (se dispara JUSTO ANTES de que el modal se muestre)
        modalDetalles.addEventListener('show.coreui.modal', function (event) {
            
            // 3. Obtiene el botón que disparó el modal
            const button = event.relatedTarget;
            
            // 4. Extrae la información de los atributos 'data-*' del botón
            const asunto = button.getAttribute('data-asunto');
            const fechaCierre = button.getAttribute('data-fecha-cierre') || 'No disponible'; // Fallback
            const descripcion = button.getAttribute('data-descripcion');
            const prioridad = button.getAttribute('data-prioridad');

            // 5. Selecciona los elementos DENTRO del modal por su ID
            const modalTitle = modalDetalles.querySelector('#modalDetallesTicketLabel');
            const modalFechaCierre = modalDetalles.querySelector('#modal-fecha-cierre');
            const modalDescripcion = modalDetalles.querySelector('#modal-descripcion');
            const modalPrioridad = modalDetalles.querySelector('#modal-prioridad');
            
            // 6. Rellena el modal con los datos extraídos
            modalTitle.textContent = 'Detalles: ' + asunto;
            modalFechaCierre.textContent = fechaCierre;
            modalDescripcion.value = descripcion; // .value para textarea

            // Recreamos la lógica del 'switch' para la prioridad
            let prioridadHtml = '';
            switch (prioridad) {
                case 'Baja':
                    prioridadHtml = '<span class="text-success">' + prioridad + '</span>';
                    break;
                case 'Media':
                    prioridadHtml = '<span class="text-warning">' + prioridad + '</span>';
                    break;
                case 'Alta':
                    prioridadHtml = '<span class="text-danger">' + prioridad + '</span>';
                    break;
                default:
                    prioridadHtml = '<span>' + (prioridad || 'N/A') + '</span>';
            }
            modalPrioridad.innerHTML = prioridadHtml; // .innerHTML para insertar HTML
        });
    });
</script>
<?= $this->endSection() ?>