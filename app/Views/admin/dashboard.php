<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Dashboard Admin - SGTS<?= $this->endSection() ?>

<?=$this->section('sidebar') ?>
    <?= $this->include('layouts/partials/admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
    <?= $this->include('layouts/partials/admin/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h1 class="mt-4">Dashboard Admin</h1>
<p>Bienvenido al panel de administración del sistema de gestión de tareas.</p>
<?= $this->endSection() ?>