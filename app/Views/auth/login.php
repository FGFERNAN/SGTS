<?= $this->extend('layouts/main') ?>

<?= $this->section('titulo') ?>Iniciar Sesión - SGTS<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5>Iniciar Sesión</h5>
            </div>
            <div class="card-body">
                <!-- Mensaje de éxito (cuando viene del registro) -->
                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error_state')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error_state') ?>
                    </div>
                <?php endif; ?>

                <!-- Errores de validación -->
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('autenticar') ?>" method="POST" id="formLogin" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label" for="email">Correo Electronico</label>
                        <input type="email" name="email" id="email" value="<?= old('email') ?>" class="form-control <?= session()->getFlashdata('error_email') != '' ? 'error-input' : '' ?>" required>
                        <div class="invalid-feedback">
                            Por favor ingresa un correo válido.
                        </div>
                        <?php if (session()->getFlashdata('error_email')): ?>
                            <div class="small text-danger mt-1">
                                <?= session()->getFlashdata('error_email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="position-relative">
                            <input type="password" name="password" id="password" class="form-control <?= session()->getFlashdata('error_password') != '' ? 'error-input' : '' ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu contraseña.
                            </div>
                            <?php if (session()->getFlashdata('error_password')): ?>
                                <div class="small text-danger mt-1">
                                    <?= session()->getFlashdata('error_password') ?>
                                </div>
                            <?php endif; ?>
                            <i class="fa-solid fa-eye-slash password-toggle d-none"></i>
                        </div>

                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="recordar" name="recordar" readonly>
                        <label class="form-check-label" for="recordar">
                            Recordarme
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= base_url('registro') ?>">¿No tienes cuenta? Regístrate</a>
                </div>
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
<?= $this->endSection() ?>