<?= $this->extend('layouts/main_template') ?>
<?= $this->section('titulo') ?>Crear Ticket - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 mx-4">
                <div class="card-body p-4">
                    <h1>Crear Ticket</h1>
                    <p class="text-body-secondary">Create Ticket</p>
                    <form action="<?= site_url('cliente/tickets/guardar') ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <?php $errors = session('errors'); ?>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['asunto']) ? 'is-invalid' : '' ?>" name="asunto" type="text" placeholder="Asunto" value="<?= old('asunto') ?>" minlength="5" maxlength="100" required>
                                    <div class="invalid-feedback <?= isset($errors['asunto']) ? 'd-none' : '' ?>">
                                        Por favor ingresa el asunto (Solo puede contener letras, números y espacios).
                                    </div>
                                    <?php if (isset($errors['asunto'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['asunto'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>" name="descripcion" type="text" placeholder="Descripción" minlength="10" maxlength="1000" required><?= old('descripcion') ?></textarea>
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
                            <div class="col-md-6">
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                        </svg></span>
                                    <select name="id_categoria" class="form-control <?= isset($errors['id_categoria']) ? 'is-invalid' : '' ?>" required>
                                        <option value="">Seleccione Categoria</option>
                                        <?php foreach ($categorias as $c) : ?>
                                            <option value="<?= $c['id_categoria'] ?>" <?= old('id_categoria') == $c['id_categoria'] ? 'selected' : '' ?>><?= $c['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback <?= isset($errors['id_categoria']) ? 'd-none' : '' ?>">
                                        Por favor selecciona una categoria.
                                    </div>
                                    <?php if (isset($errors['id_categoria'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['id_categoria'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                        </svg></span>
                                    <select name="id_prioridad_ticket" class="form-control <?= isset($errors['id_prioridad_ticket']) ? 'is-invalid' : '' ?>" required>
                                        <option value="">Seleccione Prioridad</option>
                                        <?php foreach ($prioridades as $p) : ?>
                                            <option value="<?= $p['id_prioridad_ticket'] ?>" <?= old('id_prioridad_ticket') == $p['id_prioridad_ticket'] ? 'selected' : '' ?>><?= $p['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback <?= isset($errors['id_prioridad_ticket']) ? 'd-none' : '' ?>">
                                        Por favor selecciona la prioridad.
                                    </div>
                                    <?php if (isset($errors['id_prioridad_ticket'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['id_prioridad_ticket'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-grid mx-auto">
                            <button class="btn btn-block btn-success" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>