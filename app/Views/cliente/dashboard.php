<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Dashboard Cliente - SGTS<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
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
                    <svg class="icon">
                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-plus') ?>"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border mb-0">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th width="5%" class="bg-body-secondary text-center">ID</th>
                        <th width="40%" class="bg-body-secondary text-center">Asunto</th>
                        <th width="10%" class="bg-body-secondary">Fecha Creación</th>
                        <th width="20%" class="bg-body-secondary text-center">Tecnico Asignado</th>
                        <th width="15%" class="bg-body-secondary">Categoria</th>
                        <th width="10%" class="bg-body-secondary">Estado</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <?php foreach ($tickets as $ticket): ?>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($ticket['id_ticket']) ?></div>
                            </td>
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
                                            data-asunto="<?= esc($ticket['asunto']) ?>"
                                            data-fecha-cierre="<?= esc($ticket['fecha_cierre']) ?>"
                                            data-descripcion="<?= esc($ticket['descripcion']) ?>"
                                            data-prioridad="<?= esc($ticket['prioridad']) ?>">
                                            Ver Detalles
                                        </button>
                                        <button class="dropdown-item" data-coreui-toggle="modal" data-id-ticket="<?= esc($ticket['id_ticket']) ?>" data-coreui-target="#modalComentarios">Comentarios</button>
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
            <div class="modal fade" id="modalComentarios" tabindex="-1" aria-labelledby="modalComentarios" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetallesTicketLabel">Comentarios</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= site_url('cliente/tickets/comentar') ?>" method="POST" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_ticket" id="comentario-id-ticket" value="">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="mensaje" class="col-form-label">Mensaje:</label>
                                    <textarea class="form-control" name="mensaje" id="mensaje" required></textarea>
                                </div>
                                <label class="col-form-label">Historial de Comentarios:</label>
                                <div class="list-group" id="lista-comentarios">
                                    <div class="text-center text-muted py-2">Cargando...</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
                                <button type="submit" id="btn-comentar" class="btn btn-primary" disabled>Comentar</button>
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
        const modalComentarios = document.getElementById('modalComentarios');
        const listaComentarios = document.getElementById('lista-comentarios');
        const comentarioIdTicket = modalComentarios.querySelector('#comentario-id-ticket');
        const comentarioMensaje = modalComentarios.querySelector('#mensaje');
        const btnComentar = document.getElementById('btn-comentar');

        comentarioMensaje.addEventListener('input', function() {
            if (this.value !== this.dataset.initialValue) {
                btnComentar.removeAttribute('disabled');
            } else {
                btnComentar.setAttribute('disabled', 'disabled');
            }
        });

        // 2. Escucha el evento 'show.coreui.modal' (se dispara JUSTO ANTES de que el modal se muestre)
        modalDetalles.addEventListener('show.coreui.modal', function(event) {

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

        modalComentarios.addEventListener('show.coreui.modal', function() {
            btnComentar.setAttribute('disabled', 'disabled');

            const button = event.relatedTarget;

            const idTicket = button.getAttribute('data-id-ticket');

            comentarioIdTicket.value = idTicket;

            // A. Limpiar lista anterior y mostrar "Cargando"
            listaComentarios.innerHTML = '<div class="list-group-item text-center text-muted">Cargando historial...</div>';

            fetch(`${baseUrl}cliente/tickets/obtener-comentarios/${idTicket}`)
                .then(response => response.json())
                .then(data => {
                    listaComentarios.innerHTML = '';

                    if (data.length === 0) {
                        listaComentarios.innerHTML = '<div class="list-group-item text-center text-muted small">No hay avances registrados.</div>';
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

                        listaComentarios.appendChild(item);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    listaComentarios.innerHTML = '<div class="list-group-item text-danger small">Error al cargar comentarios.</div>';
                });
        })
    });
</script>
<?= $this->endSection() ?>