<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Tickets - SGTS<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<?= $this->include('layouts/partials/admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layouts/partials/admin/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h2 class="mb-4">Tickets</h2>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border mb-0">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary text-center">Asunto</th>
                        <th class="bg-body-secondary">Fecha Creación</th>
                        <th class="bg-body-secondary text-center">Cliente</th>
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
                                <div class="text-nowrap"><?= esc($ticket['nombre_cliente']) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="text-nowrap fw-semibold <?= esc($ticket['nombre_tecnico']) ? esc($ticket['nombre_tecnico']) : 'badge text-bg-danger text-white'  ?>"><?= esc($ticket['nombre_tecnico']) ? esc($ticket['nombre_tecnico']) : 'Sin Asignar' ?></div>
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
                                            echo '<span class="text-info">' . esc($ticket['estado']) . '</span>';
                                            break;
                                        case 'En Proceso':
                                            echo '<span class="text-warning">' . esc($ticket['estado']) . '</span>';
                                            break;
                                        case 'Resuelto':
                                            echo '<span class="text-success">' . esc($ticket['estado']) . '</span>';
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
                                            data-id-ticket="<?= esc($ticket['id_ticket']) ?>"
                                            data-asunto="<?= esc($ticket['asunto']) ?>"
                                            data-fecha-cierre="<?= esc($ticket['fecha_cierre']) ?>"
                                            data-tecnico="<?= esc($ticket['id_usuario_tecnico']) ?>"
                                            data-estado="<?= esc($ticket['id_estado_ticket']) ?>"
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
                        <form action="<?= site_url('admin/tickets/asignarTecnico') ?>" method="POST" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_ticket" id="modal-id-ticket" value="">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="modal-tecnico" class="col-form-label">Técnico Asignado:</label>
                                            <select class="form-control" name="id_usuario_tecnico" id="modal-tecnico" disabled>
                                                <?php foreach ($tecnicos as $tecnico): ?>
                                                    <option value="<?= esc($tecnico['id_usuario']) ?>"><?= esc($tecnico['nombre'] . ' ' . $tecnico['apellidos']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="modal-tecnico" class="col-form-label">Estado:</label>
                                            <select class="form-control" name="id_estado_ticket" id="modal-estado" required>
                                                <?php foreach ($estados as $estado): ?>
                                                    <option value="<?= esc($estado['id_estado_ticket']) ?>"><?= esc($estado['nombre']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="modal-descripcion" class="col-form-label">Descripción:</label>
                                            <textarea class="form-control" id="modal-descripcion" readonly disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="modal-fecha-cierre" class="col-form-label">Fecha Cierre:</label>
                                            <div class="small text-body-secondary text-nowrap" id="modal-fecha-cierre"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="modal-prioridad" class="col-form-label">Prioridad:</label>
                                            <div class="fw-semibold text-nowrap" id="modal-prioridad"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="col-form-label">Historial de Avances:</label>
                                        <div class="collapse" id="avances">
                                            <div class="list-group" id="lista-observaciones">
                                                <div class="text-center text-muted py-2">Cargando...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light me-auto" data-coreui-toggle="collapse" data-coreui-target="#avances" aria-expanded="false" aria-controls="avances">Avances</button>
                                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
                                <button type="submit" id="btn-guardar-cambios" class="btn btn-primary" disabled>Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js_adicional') ?>
<script>
    const baseUrl = "<?= base_url() ?>";
    // Espera a que todo el HTML esté cargado
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Selecciona el modal
        const modalDetalles = document.getElementById('modalDetallesTicket');
        const listaObservaciones = document.getElementById('lista-observaciones');

        // 2. Selecciona los elementos DENTRO del modal por su ID
        const modalIdTicket = modalDetalles.querySelector('#modal-id-ticket');
        const modalTitle = modalDetalles.querySelector('#modalDetallesTicketLabel');
        const modalFechaCierre = modalDetalles.querySelector('#modal-fecha-cierre');
        const modalTecnico = modalDetalles.querySelector('#modal-tecnico');
        const modalEstado = modalDetalles.querySelector('#modal-estado');
        const modalDescripcion = modalDetalles.querySelector('#modal-descripcion');
        const modalPrioridad = modalDetalles.querySelector('#modal-prioridad');
        const btnGuardarCambios = document.getElementById('btn-guardar-cambios');

        modalEstado.addEventListener('change', function() {
            // Compara el valor actual con el valor 'inicial' que guardamos en el data-attribute
            if (this.value !== this.dataset.initialValue) {
                btnGuardarCambios.removeAttribute('disabled');
            } else {
                btnGuardarCambios.setAttribute('disabled', 'disabled');
            }
        });

        // 2. Escucha el evento 'show.coreui.modal' (se dispara JUSTO ANTES de que el modal se muestre)
        modalDetalles.addEventListener('show.coreui.modal', function(event) {

            btnGuardarCambios.setAttribute('disabled', 'disabled');

            // 3. Obtiene el botón que disparó el modal
            const button = event.relatedTarget;

            // 4. Extrae la información de los atributos 'data-*' del botón
            const idTicket = button.getAttribute('data-id-ticket');
            const asunto = button.getAttribute('data-asunto');
            const fechaCierre = button.getAttribute('data-fecha-cierre') || 'No disponible'; // Fallback
            const tecnico = button.getAttribute('data-tecnico') || 'No asignado'; // Fallback
            const estado = button.getAttribute('data-estado');
            const descripcion = button.getAttribute('data-descripcion');
            const prioridad = button.getAttribute('data-prioridad');

            // 5. Rellena el modal con los datos extraídos
            modalIdTicket.value = idTicket;
            modalTitle.textContent = 'Detalles: ' + asunto;
            modalFechaCierre.textContent = fechaCierre;
            modalTecnico.value = tecnico !== 'No asignado' ? tecnico : ''; // Selecciona el técnico en el select
            modalEstado.value = estado;
            modalDescripcion.value = descripcion; // .value para textarea

            // A. Limpiar lista anterior y mostrar "Cargando"
            listaObservaciones.innerHTML = '<div class="list-group-item text-center text-muted">Cargando historial...</div>';

            fetch(`${baseUrl}admin/tickets/obtener-observaciones/${idTicket}`)
                .then(response => response.json())
                .then(data => {
                    listaObservaciones.innerHTML = '';

                    if (data.length === 0) {
                        listaObservaciones.innerHTML = '<div class="list-group-item text-center text-muted small">No hay avances registrados.</div>';
                        return;
                    }

                    data.forEach(obs => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';

                        item.innerHTML = `
                            <div class="d-flex w-100 justify-content-between">
                              <h6 class="mb-1">${obs.nombre_usuario}</h6>
                              <small>${obs.fecha_comentario}</small>
                            </div>
                            <p class="mb-1">${obs.mensaje}</p>
                    `;

                        listaObservaciones.appendChild(item);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    listaObservaciones.innerHTML = '<div class="list-group-item text-danger small">Error al cargar comentarios.</div>';
                });

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