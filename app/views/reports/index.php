<?php
// reports/index.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Reportes de Gestión
    </h1>
    <button onclick="window.print()" class="btn btn-secondary">
        <i class="fas fa-file-pdf"></i> Generar Reporte PDF
    </button>
</div>

<!-- Stats Summary -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="padding: 15px; border-left-width: 2px;">
        <div style="font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px;">Total Ventas</div>
        <div style="font-size: 22px; font-weight: 700; font-family: var(--font-mono); color: #15803d;">$<?= number_format($totalVentas, 2) ?></div>
    </div>
    <div class="card" style="padding: 15px; border-left-width: 2px;">
        <div style="font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px;">Productos Agotados</div>
        <div style="font-size: 22px; font-weight: 700; font-family: var(--font-mono); color: #dc2626;"><?= count($agotados) ?></div>
    </div>
    <div class="card" style="padding: 15px; border-left-width: 2px;">
        <div style="font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px;">Alerta Bajo Stock</div>
        <div style="font-size: 22px; font-weight: 700; font-family: var(--font-mono); color: #d97706;"><?= count($bajoStock) ?></div>
    </div>
    <div class="card" style="padding: 15px; border-left-width: 2px;">
        <div style="font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px;">Valor Inventario</div>
        <div style="font-size: 22px; font-weight: 700; font-family: var(--font-mono); color: var(--bg-sidebar);">$<?= number_format($stats['valor_total_inventario'], 2) ?></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    
    <!-- Inventory Critical Section -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-title" style="color: #dc2626;"><i class="fas fa-times-circle"></i> Productos Agotados</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th style="text-align: right;">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($agotados as $p): ?>
                        <tr>
                            <td><?= $p['nombre'] ?></td>
                            <td style="text-align: right; font-family: var(--font-mono);">$<?= number_format($p['precio'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($agotados)): ?><tr><td colspan="2" style="text-align: center; color: var(--text-muted); font-size: 12px; padding: 20px;">No hay productos agotados</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-title" style="color: #d97706;"><i class="fas fa-exclamation-triangle"></i> Reposición Necesaria</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th style="text-align: center;">Stock</th>
                            <th style="text-align: center;">Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($bajoStock as $p): ?>
                        <tr>
                            <td><?= $p['nombre'] ?></td>
                            <td style="text-align: center; font-family: var(--font-mono); font-weight: 700;"><?= $p['stock'] ?></td>
                            <td style="text-align: center; font-family: var(--font-mono); color: var(--text-muted);"><?= $p['stock_minimo'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($bajoStock)): ?><tr><td colspan="3" style="text-align: center; color: var(--text-muted); font-size: 12px; padding: 20px;">No hay alertas de stock</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sales Section -->
    <div class="card">
        <div class="card-title"><i class="fas fa-chart-line"></i> Resumen de Ventas</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th style="text-align: right;">Valor</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ventas as $v): ?>
                    <tr>
                        <td style="font-family: var(--font-mono); font-weight: 700;">#<?= $v['id'] ?></td>
                        <td style="font-size: 12px;"><?= $v['cliente_nombre'] ?></td>
                        <td style="text-align: right; font-family: var(--font-mono); font-weight: 700; color: #15803d;">$<?= number_format($v['total'], 2) ?></td>
                        <td style="font-size: 11px; color: var(--text-muted);"><?= date('d/m/y', strtotime($v['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($ventas)): ?><tr><td colspan="4" style="text-align: center; color: var(--text-muted); font-size: 12px; padding: 20px;">No hay ventas registradas</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    @media print {
        .btn, .sidebar, .topbar, .tape { display: none !important; }
        .main-wrapper { margin-left: 0 !important; }
        .page-content { padding: 0 !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; margin-bottom: 20px !important; }
    }
</style>
