<header class="header header-sticky p-0 mb-4">
    <?php
    $notificaciones = obtener_notificaciones_usuario();
    $cantidad = count($notificaciones);
    ?>
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <svg class="icon icon-lg">
                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-menu') ?>"></use>
            </svg>
        </button>
        <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= site_url('admin/usuarios') ?>">Usuarios</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= site_url('admin/reportes') ?>">Reportes</a></li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link position-relative" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <svg class="icon icon-lg">
                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-bell') ?>"></use>
                    </svg>
                    <!-- 2. Badge Contador (Solo si hay notificaciones) -->
                    <?php if ($cantidad > 0): ?>
                        <span class="position-absolute top-1 start-10 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $cantidad ?>
                            <span class="visually-hidden">mensajes no leídos</span>
                        </span>
                    <?php endif; ?>
                </a>
                <!-- 3. Menú Desplegable -->
                <div class="dropdown-menu dropdown-menu-end pt-0" style="min-width: 250px;">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Notificaciones</div>
                    </div>

                    <?php if ($cantidad == 0): ?>
                        <div class="dropdown-item text-muted text-center py-3 small">
                            No tienes notificaciones nuevas.
                        </div>
                    <?php else: ?>
                        <?php foreach ($notificaciones as $n): ?>
                            <a class="dropdown-item border-bottom py-2" href="<?= site_url('notificaciones/leer/' . $n['id_notificacion']) ?>">
                                <div class="small fw-bold"><?= esc($n['titulo']) ?></div>
                                <div class="small text-muted text-truncate" style="max-width: 200px;">
                                    <?= esc($n['mensaje']) ?>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    <?= date('d/m H:i', strtotime($n['created_at'])) ?>
                                </small>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/tickets') ?>">
                    <svg class="icon icon-lg">
                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-tags') ?>"></use>
                    </svg>
                </a>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button" aria-expanded="false" data-coreui-toggle="dropdown">
                    <svg class="icon icon-lg theme-icon-active">
                        <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-contrast') ?>"></use>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="light">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-sun') ?>"></use>
                            </svg>Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="dark">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-moon') ?>"></use>
                            </svg>Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button" data-coreui-theme-value="auto">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-contrast') ?>"></use>
                            </svg>Auto
                        </button>
                    </li>
                </ul>
            </li>
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md"><img class="avatar-img" src="<?= base_url('coreui/assets/img/avatars/user_gemini.png') ?>" alt="user@email.com"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Cuenta</div>
                    <a class="dropdown-item" href="<?= site_url('admin/tickets') ?>">
                        <svg class="icon me-2">
                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-task') ?>"></use>
                        </svg> Tickets<span class="badge badge-sm bg-warning ms-2">42</span>
                    </a>
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        <div class="fw-semibold">Settings</div>
                    </div><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') ?>"></use>
                        </svg> Perfil</a><a class="dropdown-item" href="#">
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') ?>"></use>
                            </svg> Cancelar Cuenta</a><a class="dropdown-item" href="<?= site_url('logout') ?>">
                            <svg class="icon me-2">
                                <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-account-logout') ?>"></use>
                            </svg> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a>
                </li>
                <li class="breadcrumb-item active"><span>Dashboard</span>
                </li>
            </ol>
        </nav>
    </div>
</header>