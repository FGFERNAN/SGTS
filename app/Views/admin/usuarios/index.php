<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Usuarios - SGTS<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<?= $this->include('layouts/partials/admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layouts/partials/admin/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h3 class="card-title mb-0">Lista de Usuarios</h3>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= site_url('admin/usuarios/crear') ?>" class="btn btn-primary">
                    <svg class="icon">
                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user-plus') ?>"></use>
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
                        <th class="bg-body-secondary text-center">
                            <svg class="icon">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') ?>"></use>
                            </svg>
                        </th>
                        <th class="bg-body-secondary">Nombre</th>
                        <th class="bg-body-secondary text-center">Correo</th>
                        <th class="bg-body-secondary text-center">Rol</th>
                        <th class="bg-body-secondary">Estado</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <?php foreach ($usuarios as $usuario): ?>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($usuario['id_usuario']) ?></div>
                            </td>
                            <td>
                                <div class="text-nowrap"><?= esc($usuario['nombre']) . ' ' . esc($usuario['apellidos']) ?></div>
                                <div class="small text-body-secondary text-nowrap"> Registered: Jan 1, 2023</div>
                            </td>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($usuario['email']) ?></div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <div class="text-nowrap small text-body-secondary ms-3"><?= esc($usuario['rol']) ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-nowrap">
                                    <?php if ($usuario['id_estado_usuario'] == 1): ?>
                                        <span class="text-success"><?= esc($usuario['estado']) ?></span>
                                    <?php else: ?>
                                        <span class="text-danger"><?= esc($usuario['estado']) ?></span>
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
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="<?= site_url('admin/usuarios/editar/' . $usuario['id_usuario']) ?>">Editar</a>
                                        <?php if ($usuario['id_estado_usuario'] == 1): ?>
                                            <a class="dropdown-item text-danger" href="<?= site_url('admin/usuarios/eliminar/' . $usuario['id_usuario']) ?>">Inactivar</a>
                                        <?php else: ?>
                                            <a class="dropdown-item text-success" href="<?= site_url('admin/usuarios/eliminar/' . $usuario['id_usuario']) ?>">Activar</a>
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