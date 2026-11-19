<?php
// dashboard.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase; color: var(--bg-sidebar);">
        General Status
    </h1>
    <div style="font-family: var(--font-mono); font-size: 11px; background: var(--bg-sidebar); color: var(--accent); padding: 4px 10px;">
        LIVE FEED
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px;">
    
    <div class="card" style="border-left-color: var(--accent);">
        <div class="card-title">
            <i class="fas fa-boxes"></i> Productos Registrados
        </div>
        <div style="font-size: 32px; font-weight: 700; font-family: var(--font-mono);"><?= $stats['total_productos'] ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Unidades en catálogo</div>
    </div>

    <div class="card" style="border-left-color: #15803d;">
        <div class="card-title">
            <i class="fas fa-dollar-sign"></i> Valor Inventario
        </div>
        <div style="font-size: 32px; font-weight: 700; font-family: var(--font-mono);">$<?= number_format($stats['valor_total_inventario'], 2) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Capital activo</div>
    </div>

    <div class="card" style="border-left-color: #d97706;">
        <div class="card-title">
            <i class="fas fa-exclamation-triangle"></i> Bajo Stock
        </div>
        <div style="font-size: 32px; font-weight: 700; font-family: var(--font-mono); color: #d97706;"><?= $stats['bajo_stock'] ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Requieren reposición</div>
    </div>

    <div class="card" style="border-left-color: #dc2626;">
        <div class="card-title">
            <i class="fas fa-times-circle"></i> Agotados
        </div>
        <div style="font-size: 32px; font-weight: 700; font-family: var(--font-mono); color: #dc2626;"><?= $stats['agotados'] ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Sin disponibilidad</div>
    </div>

</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    
    <!-- Recent Sales -->
    <div class="card">
        <div class="card-title">
            <i class="fas fa-shopping-cart"></i> Últimas Ventas
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ventas)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-muted);">No hay ventas registradas</td></tr>
                    <?php else: ?>
                        <?php foreach($ventas as $v): ?>
                        <tr>
                            <td style="font-family: var(--font-mono); font-weight: 700;">#<?= $v['id'] ?></td>
                            <td><?= $v['cliente_nombre'] ?></td>
                            <td style="font-family: var(--font-mono); font-weight: 700; color: #15803d;">$<?= number_format($v['total'], 2) ?></td>
                            <td style="font-size: 12px; color: var(--text-muted);"><?= date('d/m/Y H:i', strtotime($v['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="card">
        <div class="card-title">
            <i class="fas fa-stream"></i> Actividad Reciente
        </div>
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <?php if (empty($actividad)): ?>
                <div style="text-align: center; color: var(--text-muted); font-size: 12px;">Sin actividad reciente</div>
            <?php else: ?>
                <?php foreach($actividad as $log): ?>
                <div style="padding-bottom: 12px; border-bottom: 1px dashed var(--border-color);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span class="badge" style="background: var(--bg-sidebar); color: var(--text-light); font-size: 8px;"><?= $log['accion'] ?></span>
                        <span style="font-size: 10px; color: var(--text-muted);"><?= date('H:i', strtotime($log['fecha_hora'])) ?></span>
                    </div>
                    <p style="font-size: 12px; font-weight: 500; line-height: 1.4;"><?= $log['detalle'] ?></p>
                    <div style="font-size: 10px; color: var(--accent); margin-top: 4px; font-family: var(--font-mono);"><?= $log['usuario_nombre'] ?></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>
