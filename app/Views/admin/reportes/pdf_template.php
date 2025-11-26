<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Tickets</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 20px; }
        .info { margin-bottom: 15px; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .estado-cerrado { color: #dc3545; } /* Rojo */
        .estado-abierto { color: #198754; } /* Verde */
    </style>
</head>
<body>

    <h1>Reporte de Gestión de Tickets</h1>

    <div class="info">
        <strong>Fecha de generación:</strong> <?= $fecha_generacion ?><br>
        <strong>Total registros:</strong> <?= count($tickets) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Fecha</th>
                <th width="25%">Asunto</th>
                <th width="15%">Cliente</th>
                <th width="15%">Técnico</th>
                <th width="15%">Categoría</th>
                <th width="10%">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td><?= $t['id_ticket'] ?></td>
                    <td><?= date('d/m/Y', strtotime($t['fecha_creacion'])) ?></td>
                    <td><?= $t['asunto'] ?></td>
                    <td><?= $t['nombre_cliente'] ?></td>
                    <td><?= !empty($t['nombre_tecnico']) ? $t['nombre_tecnico'] : '---' ?></td>
                    <td><?= $t['categoria'] ?></td>
                    <td><?= $t['estado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>