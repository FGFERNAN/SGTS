<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Roles - SGTS<?= $this->endSection() ?>

<?=$this->section('sidebar') ?>
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
                <h3 class="card-title mb-0">Lista de Roles</h3>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= site_url('admin/roles/crear') ?>" class="btn btn-primary">
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
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <?php foreach ($roles as $rol): ?>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($rol['id_rol']) ?></div>
                            </td>
                            <td>
                                <div class="text-nowrap"><?= esc($rol['nombre']) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="text-nowrap"><?= esc($rol['descripcion']) ?></div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-options') ?>"></use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="<?= site_url('admin/roles/editar/' . $rol['id_rol']) ?>">Editar</a>
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