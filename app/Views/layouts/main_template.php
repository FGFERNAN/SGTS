<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('titulo')?></title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="<?= base_url('coreui/vendors/simplebar/css/simplebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('coreui/css/vendors/simplebar.css') ?>">
    <!-- Main styles for this application-->
    <link href="<?= base_url('coreui/css/style.css') ?>" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="<?= base_url('coreui/css/examples.css') ?>" rel="stylesheet">
    <script src="<?= base_url('coreui/js/config.js') ?>"></script>
    <script src="<?= base_url('coreui/js/color-modes.js') ?>"></script>
    <link href="<?= base_url('coreui/vendors/@coreui/chartjs/css/coreui-chartjs.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?= $this->include('layouts/sidebar') ?>

    <div class="wrapper d-flex flex-column min-vh-100">
        <?= $this->include('layouts/navbar') ?>
        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <?= $this->renderSection('contenido') ?>
            </div>
        </div>
        <?= $this->include('layouts/footer') ?>
    </div>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- CoreUI and necessary plugins-->
    <script src="<?= base_url('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') ?>"></script>
    <script src="<?= base_url('coreui/vendors/simplebar/js/simplebar.min.js') ?>"></script>
    <script>
      const header = document.querySelector('header.header');

      document.addEventListener('scroll', () => {
        if (header) {
          header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
      });
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="<?= base_url('coreui/vendors/chart.js/js/chart.umd.js') ?>"></script>
    <script src="<?= base_url('coreui/vendors/@coreui/chartjs/js/coreui-chartjs.js') ?>"></script>
    <script src="<?= base_url('coreui/vendors/@coreui/utils/js/index.js') ?>"></script>
    <script src="<?= base_url('coreui/js/main.js') ?>"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <?= $this->renderSection('js_adicional') ?>
</body>

</html>