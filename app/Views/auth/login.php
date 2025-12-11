<?= $this->extend('layouts/main') ?>

<?= $this->section('titulo') ?>Iniciar Sesión - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <h1>Login</h1>
                        <p class="text-body-secondary">Sign In to your account</p>
                        <form action="<?= base_url('autenticar') ?>" method="POST" id="formLogin" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <?php $errors = session('errors'); ?>
                            <div class="input-group mb-3"><span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                    </svg></span>
                                <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="Email" required>
                                <div class="invalid-feedback <?= isset($errors['email']) ? 'd-none' : '' ?>">
                                    Por favor ingresa un correo válido.
                                </div>
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('error_email')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('error_email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="input-group mb-4"><span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                    </svg></span>
                                <input type="password" placeholder="Password" name="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" required>
                                <span class="password-toggle d-none" style="cursor: pointer;">
                                    <i class="fa fa-eye-slash"></i>
                                </span>
                                <div class="invalid-feedback <?= isset($errors['password']) ? 'd-none' : '' ?>">
                                    Por favor ingresa tu contraseña.
                                </div>
                                <?php if (isset($errors['password'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('error_password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('error_password') ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('error_state')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('error_state') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <!-- <div class="col-6 text-end">
                                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <!-- Mensaje de éxito (cuando viene del registro) -->
                            <?php if (session()->has('success')): ?>
                                <p><?= session('success') ?></p>
                            <?php else: ?>
                                <p>¿No tienes cuenta? Regístrate dando clic en el botón de abajo.</p>
                            <?php endif; ?>
                            <a href="<?= base_url('registro') ?>" class="btn btn-lg btn-outline-light mt-3">Register Now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Error -->
<div class="modal fade" id="modalErrorAcceso" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalErrorLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Acceso Restringido
                </h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí imprimimos el mensaje flashdata -->
                <?= session()->getFlashdata('error') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-toggle');

        passwordInput.addEventListener('input', () => {
            if (passwordInput.value.length > 0) {
                toggleIcon.classList.remove('d-none');
            } else {
                toggleIcon.classList.add('d-none');
            }
        });

        toggleIcon.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    })
</script>
<!-- Script para detectar y mostrar el modal automáticamente -->
<?php if (session()->getFlashdata('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Identificar el modal por su ID
            const modalElement = document.getElementById('modalErrorAcceso');
            
            // 2. Instanciar el modal usando Bootstrap/CoreUI
            // (Asegúrate de que bootstrap.js o coreui.js ya esté cargado antes de esto)
            const errorModal = new coreui.Modal(modalElement);
            
            // 3. Mostrar el modal
            errorModal.show();
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>