<?= $this->extend('layouts/main_template') ?>

<?= $this->section('titulo') ?>Reportes de Tickets - SGTS<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<?= $this->include('layouts/partials/admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layouts/partials/admin/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h2 class="mb-4">Graficos Estadisticos</h2>
<!-- 2. GRÁFICOS ESTADÍSTICOS -->
<div class="row mb-5">

    <!-- Gráfico 1: Tickets por Estado (Pastel) -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie text-info"></i> Distribución por Estado</h6>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="height: 300px; width: 100%;">
                    <canvas id="ticketsPorEstadoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico 2: Tickets por Categoría (Barras) - Placeholder para futura implementación -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar text-success"></i> Tickets por Categoría</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <canvas id="ticketsPorCategoriaChart"></canvas>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
<?= $this->section('js_adicional') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. OBTENER DATOS DE PHP (JSON)
        const datosEstado = JSON.parse('<?= $grafico1Json ?>');
        const datosCategoria = JSON.parse('<?= $grafico2Json ?>');

        // 2. CONFIGURACIÓN Y DIBUJO DEL GRÁFICO 1: Distribución por Estado (Doughnut Chart)
        if (datosEstado.data && datosEstado.data.length > 0) {
            const ctx1 = document.getElementById('ticketsPorEstadoChart');
            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: datosEstado.labels,
                    datasets: [{
                        label: 'Tickets',
                        data: datosEstado.data,
                        backgroundColor: datosEstado.colores,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                // Muestra el porcentaje en el tooltip
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.parsed;
                                        const percentage = Math.round((value / total) * 100);
                                        label += value + ' (' + percentage + '%)';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // 3. CONFIGURACIÓN Y DIBUJO DEL GRÁFICO 2: Tickets por Categoría (Bar Chart)
        if (datosCategoria.data && datosCategoria.data.length > 0) {
            const ctx2 = document.getElementById('ticketsPorCategoriaChart');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: datosCategoria.labels,
                    datasets: [{
                        label: 'Número de Tickets',
                        data: datosCategoria.data,
                        backgroundColor: datosCategoria.colores,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' tickets';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>