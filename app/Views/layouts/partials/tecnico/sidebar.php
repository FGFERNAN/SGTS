<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                <use xlink:href="<?= base_url('coreui/assets/brand/coreui.svg#full') ?>"></use>
            </svg>
            <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                <use xlink:href="<?= base_url('coreui/assets/brand/coreui.svg#signet') ?>"></use>
            </svg>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">
                <svg class="nav-icon">
                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-tags') ?>"></use>
                </svg> Dashboard<!--<span class="badge badge-sm bg-info ms-auto">NEW</span>--></a></li>
        <li class="nav-title">Tickets</li>
        <li class="nav-item"><a class="nav-link" href="widgets.html">
                <svg class="nav-icon">
                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-check-circle') ?>"></use>
                </svg> Resueltos<span class="badge badge-sm bg-info ms-auto">20</span></a></li>
        <li class="nav-divider"></li>
        <li class="nav-title">Analisis</li>
        <li class="nav-item"><a class="nav-link" href="https://coreui.io/bootstrap/docs/templates/installation/" target="_blank">
                <svg class="nav-icon">
                    <use xlink:href="<?= base_url('coreui/vendors/@coreui/icons/svg/free.svg#cil-chart-pie') ?>"></use>
                </svg> Reportes</a></li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <a href="<?= site_url('logout') ?>" class="sidebar-toggler" type="button"></a>
    </div>
</div>