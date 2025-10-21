<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - SGTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h5>Registro de Usuario</h5>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('auth/guardar') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= old('nombre') ?>" minlength="3" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= old('apellidos') ?>" minlength="3" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_documento" class="form-label">Tipo Documento</label>
                                <select name="id_tipo_documento" class="form-control" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Tarjeta de Identidad</option>
                                    <option value="2">Cedula de Ciudadania</option>
                                    <option value="3">Cedula de Extranjeria</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Numero Documento</label>
                                <input type="text" id="id_usuario" name="id_usuario" class="form-control" value="<?= old('id_usuario') ?>" inputmode="numeric" minlength="6" maxlength="10" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" minlength="6" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirmar Contraseña</label>
                                <input type="password" name="confirm_password" class="form-control" required>
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
    </div>
</body>

</html>