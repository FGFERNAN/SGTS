<?= $this->extend('layouts/error_template') ?>
<?= $this->section('contenido') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="clearfix">
                <h1 class="float-start display-3 me-4">403</h1>
                <h4 class="pt-3">Oops! Forbidden.</h4>
                <p class="text-body-secondary">You don't have permission to access this resource.</p>
            </div>
            <div class="d-grid col-2 mx-auto mt-3">
                <a class="btn btn-primary" href="<?= site_url('/') ?>">Home</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>