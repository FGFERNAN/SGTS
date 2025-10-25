<?= $this->extend('layouts/main') ?>

<?= $this->section('titulo') ?>Registrarse - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-primary text-white">
                <h5>Registro de Usuario</h5>
            </div>
            <div class="card-body">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= session('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/guardar') ?>" method="POST" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <?php $errors = session('errors'); ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?= old('nombre') ?>" minlength="3" maxlength="50" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu nombre.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= old('apellidos') ?>" minlength="3" maxlength="50" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tus apellidos.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        <div class="invalid-feedback">
                            Por favor ingresa un correo válido.
                        </div>
                        <?php if (isset($errors['email'])) : ?>
                            <div class="small text-danger mt-1">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_documento" class="form-label">Tipo Documento</label>
                        <select name="id_tipo_documento" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            <option value="1">Tarjeta de Identidad</option>
                            <option value="2">Cedula de Ciudadania</option>
                            <option value="3">Cedula de Extranjeria</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor selecciona un tipo de documento.
                        </div>
                        <?php if (isset($errors['id_tipo_documento'])) : ?>
                            <div class="small text-danger mt-1">
                                <?= $errors['id_tipo_documento'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Numero Documento</label>
                        <input type="text" id="id_usuario" name="id_usuario" class="form-control" value="<?= old('id_usuario') ?>" inputmode="numeric" minlength="6" maxlength="10" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu número de documento.
                        </div>
                        <?php if (isset($errors['id_usuario'])) : ?>
                            <div class="small text-danger mt-1">
                                <?= $errors['id_usuario'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="6" maxlength="8" required>
                        <div class="invalid-feedback">
                            Por favor ingresa una contraseña entre 6 y 8 caracteres.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Confirmar Contraseña</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor confirma tu contraseña.
                        </div>
                        <?php if (isset($errors['confirm_password'])) : ?>
                            <div class="small text-danger mt-1">
                                <?= $errors['confirm_password'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar</button>
                </form>
                <div class="text-center mt-3">
                    <p>¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Iniciar sesión</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>