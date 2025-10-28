<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Usuarios - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
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
                <th class="bg-body-secondary text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                <?php foreach ($usuarios as $usuario): ?>
                <td class="text-center">
                    <div class="text-nowrap"><?= $usuario['id_usuario'] ?></div>
                </td>
                <td>
                    <div class="text-nowrap"><?= $usuario['nombre'] . ' ' . $usuario['apellidos'] ?></div>
                    <div class="small text-body-secondary text-nowrap"> Registered: Jan 1, 2023</div>
                </td>
                <td class="text-center">
                    <div class="text-nowrap"><?= $usuario['email'] ?></div>
                </td>
                <td>
                    <div class="d-flex justify-content-between align-items-baseline">
                        <div class="text-nowrap small text-body-secondary ms-3"><?= $usuario['rol'] ?></div>
                    </div>
                </td>
                <td>
                    <div class="fw-semibold text-nowrap"><?= $usuario['estado'] ?></div>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Info</a><a class="dropdown-item" href="#">Edit</a><a class="dropdown-item text-danger" href="#">Delete</a></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>