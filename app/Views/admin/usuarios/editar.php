<?= $this->extend('layouts/main_template') ?>
<?= $this->section('titulo') ?>Editar Usuario - SGTS<?= $this->endSection() ?>

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
                    <h1>Editar Usuario</h1>
                    <p class="text-body-secondary">Edit account</p>
                    <form action="<?= site_url('admin/usuarios/actualizar/' . $usuario['id_usuario']) ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <?php $errors = session('errors'); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" name="nombre" type="text" placeholder="Nombre" value="<?= old('nombre', esc($usuario['nombre'])) ?>" minlength="3" maxlength="50" required>
                                    <div class="invalid-feedback <?= isset($errors['nombre']) ? 'd-none' : '' ?>">
                                        Por favor ingresa tu nombre (Solo letras).
                                    </div>
                                    <?php if (isset($errors['nombre'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['nombre'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['apellidos']) ? 'is-invalid' : '' ?>" name="apellidos" type="text" placeholder="Apellidos" value="<?= old('apellidos', esc($usuario['apellidos'])) ?>" minlength="3" maxlength="50" required>
                                    <div class="invalid-feedback <?= isset($errors['apellidos']) ? 'd-none' : '' ?>">
                                        Por favor ingresa tus apellidos (Solo letras).
                                    </div>
                                    <?php if (isset($errors['apellidos'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['apellidos'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" type="email" placeholder="Email" value="<?= old('email', esc($usuario['email'])) ?>" required>
                                    <div class="invalid-feedback <?= isset($errors['email']) ? 'd-none' : '' ?>">
                                        Por favor ingresa un correo válido.
                                    </div>
                                    <?php if (isset($errors['email'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                        </svg></span>
                                    <select name="id_rol" class="form-control <?= isset($errors['id_rol']) ? 'is-invalid' : '' ?>" required>
                                        <option value="">Seleccione Rol</option>
                                        <?php foreach ($roles as $rol) : ?>
                                            <option value="<?= $rol['id_rol'] ?>" <?= old('id_rol', $usuario['id_rol']) == $rol['id_rol'] ? 'selected' : '' ?>><?= $rol['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback <?= isset($errors['id_rol']) ? 'd-none' : '' ?>">
                                        Por favor selecciona un rol.
                                    </div>
                                    <?php if (isset($errors['id_rol'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['id_rol'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                        </svg></span>
                                    <select name="id_tipo_documento" class="form-control <?= isset($errors['id_tipo_documento']) ? 'is-invalid' : '' ?>" required>
                                        <option value="" <?= old('id_tipo_documento') == '' ? 'selected' : '' ?>>Tipo Documento</option>
                                        <option value="1" <?= old('id_tipo_documento', $usuario['id_tipo_documento']) == '1' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                        <option value="2" <?= old('id_tipo_documento', $usuario['id_tipo_documento']) == '2' ? 'selected' : '' ?>>Cedula de Ciudadania</option>
                                        <option value="3" <?= old('id_tipo_documento', $usuario['id_tipo_documento']) == '3' ? 'selected' : '' ?>>Cedula de Extranjeria</option>
                                    </select>
                                    <div class="invalid-feedback <?= isset($errors['id_tipo_documento']) ? 'd-none' : '' ?>">
                                        Por favor selecciona un tipo de documento.
                                    </div>
                                    <?php if (isset($errors['id_tipo_documento'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['id_tipo_documento'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                        </svg></span>
                                    <input class="form-control <?= isset($errors['id_usuario']) ? 'is-invalid' : '' ?>" name="id_usuario" type="text" value="<?= old('id_usuario', esc($usuario['id_usuario'])) ?>" inputmode="numeric" pattern="(\d{8})|(\d{10})|(\d{11})|(\d{6}-\d{5})" placeholder="Número Documento" readonly disabled>
                                    <div class="invalid-feedback <?= isset($errors['id_usuario']) ? 'd-none' : '' ?>">
                                        Por favor ingresa tu número de documento (Entre 8 y 11 caracteres).
                                    </div>
                                    <?php if (isset($errors['id_usuario'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['id_usuario'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-between mx-auto">
                                <button class="btn btn-block btn-success" type="submit">Guardar</button>
                                <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-secondary btn-danger">Cancelar</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>