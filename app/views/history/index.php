<?php
// history/index.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Historial de Actividades
    </h1>
    <div style="font-family: var(--font-mono); font-size: 11px; background: var(--bg-sidebar); color: var(--accent); padding: 4px 10px;">
        REGISTRO DEL SISTEMA
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th style="width: 120px;">Acción</th>
                    <th>Detalle de la Actividad</th>
                    <th>Usuario</th>
                    <th style="width: 200px;">Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($logs as $log): ?>
                <tr>
                    <td style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">#<?= $log['id'] ?></td>
                    <td>
                        <?php 
                        $badgeClass = '';
                        switch($log['accion']) {
                            case 'crear': $badgeClass = 'badge-success'; break;
                            case 'editar': $badgeClass = 'badge-warning'; break;
                            case 'eliminar': $badgeClass = 'badge-danger'; break;
                            case 'venta': $badgeClass = 'badge-primary'; break;
                            case 'login': $badgeClass = 'badge-secondary'; break;
                            default: $badgeClass = '';
                        }
                        ?>
                        <span class="badge <?= $badgeClass ?>" style="<?= $log['accion'] == 'login' ? 'background: #292524; color: white;' : '' ?>">
                            <?= $log['accion'] ?>
                        </span>
                    </td>
                    <td style="font-weight: 500; font-size: 13px;"><?= $log['detalle'] ?></td>
                    <td>
                        <div style="font-size: 13px; font-weight: 700;"><?= $log['usuario_nombre'] ?></div>
                    </td>
                    <td style="font-size: 12px; color: var(--text-muted); font-family: var(--font-mono);">
                        <?= date('d/m/Y H:i:s', strtotime($log['fecha_hora'])) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .badge-primary { background: rgba(217,119,6,.1); color: #d97706; }
    .badge-secondary { background: #e5e7eb; color: #374151; }
</style>
