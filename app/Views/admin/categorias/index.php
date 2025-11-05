<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Categorias - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h3 class="card-title mb-0">Categorias Tickets</h3>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= site_url('admin/categorias/crear') ?>" class="btn btn-primary">
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
                        <th class="bg-body-secondary text-center">
                            <svg class="icon">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') ?>"></use>
                            </svg>
                        </th>
                        <th class="bg-body-secondary">Nombre</th>
                        <th class="bg-body-secondary text-center">Descripción</th>
                        <th class="bg-body-secondary">Estado</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <?php foreach ($categorias as $c): ?>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($c['id_categoria']) ?></div>
                            </td>
                            <td>
                                <div class="text-nowrap"><?= esc($c['nombre']) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($c['descripcion']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-nowrap">
                                    <?php if ($c['id_estado_categoria'] == 1): ?>
                                        <span class="text-success"><?= esc($c['estado']) ?></span>
                                    <?php else: ?>
                                        <span class="text-danger"><?= esc($c['estado']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-options') ?>"></use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="<?= site_url('admin/categorias/editar/' . $c['id_categoria']) ?>">Editar</a>
                                        <?php if ($c['id_estado_categoria'] == 1): ?>
                                            <a class="dropdown-item text-danger" href="<?= site_url('admin/categorias/eliminar/' . $c['id_categoria']) ?>">Inactivar</a>
                                        <?php else: ?>
                                            <a class="dropdown-item text-success" href="<?= site_url('admin/categorias/eliminar/' . $c['id_categoria']) ?>">Activar</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>