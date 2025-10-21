<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión - SGTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
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

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
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

                        <form action="<?= base_url('autenticar') ?>" method="POST" id="formLogin">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label" for="email">Correo Electronico</label>
                                <input type="email" name="email" id="email" value="<?= old('email') ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="recordar" name="recordar">
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
    </div>
</body>

</html>