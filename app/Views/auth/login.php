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
                            <div class="input-group mb-3"><span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                                    </svg></span>
                                <input class="form-control <?= session()->getFlashdata('error_email') != '' ? 'error-input' : '' ?>" type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un correo válido.
                                </div>
                                <?php if (session()->getFlashdata('error_email')): ?>
                                    <div class="small text-danger mt-1">
                                        <?= session()->getFlashdata('error_email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="input-group mb-4"><span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                                    </svg></span>
                                <input type="password" placeholder="Password" name="password" id="password" class="form-control <?= session()->getFlashdata('error_password') != '' ? 'error-input' : '' ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu contraseña.
                                </div>
                                <?php if (session()->getFlashdata('error_password')): ?>
                                    <div class="small text-danger mt-1">
                                        <?= session()->getFlashdata('error_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a href="<?= base_url('registro') ?>" class="btn btn-lg btn-outline-light mt-3">Register Now!</a>
                        </div>
                    </div>
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