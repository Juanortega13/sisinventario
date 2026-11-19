<?php
// billing/list.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Historial de Facturación
    </h1>
    <a href="index.php?route=billing/create" class="btn btn-primary">
        <i class="fas fa-file-invoice-dollar"></i> Nueva Factura
    </a>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th style="text-align: right;">Total</th>
                    <th>Vendedor</th>
                    <th>Fecha y Hora</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($facturas)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">No hay facturas registradas.</td></tr>
                <?php else: ?>
                    <?php foreach($facturas as $f): ?>
                    <tr>
                        <td style="font-family: var(--font-mono); font-weight: 700;">#<?= str_pad($f['id'], 5, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $f['cliente_nombre'] ?></td>
                        <td style="text-align: right; font-family: var(--font-mono); font-weight: 700; color: #15803d;">
                            $<?= number_format($f['total'], 2) ?>
                        </td>
                        <td style="font-size: 13px;"><?= $f['usuario_nombre'] ?></td>
                        <td style="font-size: 13px; color: var(--text-muted);"><?= date('d/m/Y H:i', strtotime($f['created_at'])) ?></td>
                        <td style="text-align: center;">
                            <a href="index.php?route=billing/detail&id=<?= $f['id'] ?>" class="btn" style="padding: 6px 12px; border: 1px solid var(--border-color); color: var(--bg-sidebar);">
                                <i class="fas fa-eye"></i> Ver Detalle
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
