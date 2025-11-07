<?= $this->extend('layouts/main_template') ?>
<?= $this->section('titulo') ?>Editar Categoria - SGTS<?= $this->endSection() ?>

<?=$this->section('sidebar') ?>
    <?= $this->include('layouts/partials/admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
    <?= $this->include('layouts/partials/admin/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 mx-4">
                <div class="card-body p-4">
                    <h1>Editar Categoria</h1>
                    <p class="text-body-secondary">Edit category</p>
                    <form action="<?= site_url('admin/categorias/actualizar/' . esc($categoria['id_categoria'])) ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <?php $errors = session('errors'); ?>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" name="nombre" type="text" placeholder="Nombre" value="<?= old('nombre', esc($categoria['nombre'])) ?>" minlength="3" maxlength="50" required>
                                    <div class="invalid-feedback <?= isset($errors['nombre']) ? 'd-none' : '' ?>">
                                        Por favor ingresa el nombre.
                                    </div>
                                    <?php if (isset($errors['nombre'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['nombre'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>" name="descripcion" type="text" placeholder="Descripción" value="<?= old('descripcion') ?>" minlength="5" maxlength="500" required><?= esc($categoria['descripcion']) ?></textarea>
                                    <div class="invalid-feedback <?= isset($errors['descripcion']) ? 'd-none' : '' ?>">
                                        Por favor ingresa la descripción.
                                    </div>
                                    <?php if (isset($errors['descripcion'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['descripcion'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4 d-grid mx-auto">
                                <button class="btn btn-block btn-success" type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>