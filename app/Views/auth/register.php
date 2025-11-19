<?= $this->extend('layouts/main') ?>

<?= $this->section('titulo') ?>Registrarse - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card mb-4 mx-4">
                <div class="card-body p-4">
                    <h1>Registro</h1>
                    <p class="text-body-secondary">Create your account</p>
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('auth/guardar') ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <?php $errors = session('errors'); ?>
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                </svg></span>
                            <input type="text" id="nombre" name="nombre" placeholder="Nombre" class="form-control <?= isset($errors['nombre']) ? 'error-input' : '' ?>" value="<?= old('nombre') ?>" minlength="3" maxlength="50" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu nombre (Solo letras).
                            </div>
                            <?php if (isset($errors['nombre'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['nombre'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') ?>"></use>
                                </svg></span>
                            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" class="form-control <?= isset($errors['apellidos']) ? 'error-input' : '' ?>" value="<?= old('apellidos') ?>" minlength="3" maxlength="50" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tus apellidos (Solo letras).
                            </div>
                            <?php if (isset($errors['apellidos'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['apellidos'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                </svg></span>
                            <input type="email" id="email" name="email" placeholder="Email" class="form-control <?= isset($errors['email']) ? 'error-input' : '' ?>" value="<?= old('email') ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingresa un correo válido.
                            </div>
                            <?php if (isset($errors['email'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                </svg></span>
                            <select name="id_tipo_documento" class="form-control <?= isset($errors['id_tipo_documento']) ? 'error-input' : '' ?>" required>
                                <option value="" <?= old('id_tipo_documento') == '' ? 'selected' : '' ?>>Tipo Documento</option>
                                <option value="1" <?= old('id_tipo_documento') == '1' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                <option value="2" <?= old('id_tipo_documento') == '2' ? 'selected' : '' ?>>Cedula de Ciudadania</option>
                                <option value="3" <?= old('id_tipo_documento') == '3' ? 'selected' : '' ?>>Cedula de Extranjeria</option>
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
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                </svg></span>
                            <input type="text" id="id_usuario" name="id_usuario" placeholder="Numero Documento" class="form-control <?= isset($errors['id_usuario']) ? 'error-input' : '' ?>" value="<?= old('id_usuario') ?>" inputmode="numeric" pattern="(\d{8})|(\d{10})|(\d{11})|(\d{6}-\d{5})" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu número de documento (Entre 8 y 11 caracteres).
                            </div>
                            <?php if (isset($errors['id_usuario'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['id_usuario'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                </svg></span>
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control <?= isset($errors['password']) ? 'error-input' : '' ?>" pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}" required>
                            <div class="invalid-feedback">
                                Por favor ingresa una contraseña (Debe tener entre 6 y 20 caracteres, e incluir al menos una mayúscula, una minúscula, un número y un carácter especial.).
                            </div>
                            <?php if (isset($errors['password'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-4"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                </svg></span>
                            <input type="password" placeholder="Confirmar Password" name="confirm_password" class="form-control <?= isset($errors['confirm_password']) ? 'error-input' : '' ?>" required>
                            <div class="invalid-feedback">
                                Por favor confirma tu contraseña.
                            </div>
                            <?php if (isset($errors['confirm_password'])) : ?>
                                <div class="small text-danger mt-1">
                                    <?= $errors['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button class="btn btn-block btn-success" type="submit">Crear Cuenta</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>