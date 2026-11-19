<?php
// billing/detail.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Detalle de Factura
    </h1>
    <div>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Imprimir
        </button>
        <a href="index.php?route=billing" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>
</div>

<div id="invoice-printable" style="background: white; border: 1px solid var(--border-color); padding: 60px; max-width: 900px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,.05); position: relative;">
    
    <!-- Design elements -->
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 10px; background: repeating-linear-gradient(-55deg, var(--accent), var(--accent) 15px, #292524 15px, #292524 30px);"></div>

    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 60px;">
        <div>
            <div style="border: 3px solid #292524; display: inline-block; padding: 10px 20px; transform: rotate(-2deg); margin-bottom: 20px;">
                <span style="font-family: var(--font-mono); font-size: 28px; font-weight: 700; letter-spacing: 4px; color: #292524;">FERRO<span style="color: var(--accent);">STOCK</span></span>
            </div>
            <div style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); line-height: 1.6;">
                NIT: 900.123.456-7<br>
                AV. INDUSTRIAL #45-12<br>
                TEL: (605) 311 1012<br>
                CIUDAD, PAÍS
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-family: var(--font-mono); font-size: 14px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">FACTURA DE VENTA</div>
            <div style="font-family: var(--font-mono); font-size: 36px; font-weight: 700; color: var(--accent);">#<?= str_pad($factura['id'], 5, '0', STR_PAD_LEFT) ?></div>
            <div style="font-family: var(--font-mono); font-size: 11px; margin-top: 10px;">FECHA: <?= date('d/m/Y', strtotime($factura['created_at'])) ?></div>
            <div style="font-family: var(--font-mono); font-size: 11px;">HORA: <?= date('H:i:s', strtotime($factura['created_at'])) ?></div>
        </div>
    </div>

    <div style="padding: 24px; background: #faf8f5; border-left: 4px solid var(--bg-sidebar); margin-bottom: 40px;">
        <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px;">DATOS DEL CLIENTE</div>
        <div style="font-size: 20px; font-weight: 700; text-transform: uppercase;"><?= $factura['cliente_nombre'] ?></div>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 60px;">
        <thead>
            <tr style="border-bottom: 2px solid var(--bg-sidebar);">
                <th style="padding: 12px; text-align: left; font-family: var(--font-mono); font-size: 11px;">ITEM / PRODUCTO</th>
                <th style="padding: 12px; text-align: center; font-family: var(--font-mono); font-size: 11px; width: 80px;">CANT.</th>
                <th style="padding: 12px; text-align: right; font-family: var(--font-mono); font-size: 11px; width: 140px;">UNITARIO</th>
                <th style="padding: 12px; text-align: right; font-family: var(--font-mono); font-size: 11px; width: 140px;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($factura['detalles'] as $d): ?>
            <tr style="border-bottom: 1px dashed var(--border-color);">
                <td style="padding: 16px 12px;">
                    <span style="font-weight: 700; font-size: 14px;"><?= $d['producto_nombre'] ?></span>
                </td>
                <td style="padding: 16px 12px; text-align: center; font-family: var(--font-mono);"><?= $d['cantidad'] ?></td>
                <td style="padding: 16px 12px; text-align: right; font-family: var(--font-mono);">$<?= number_format($d['precio_unitario'], 2) ?></td>
                <td style="padding: 16px 12px; text-align: right; font-family: var(--font-mono); font-weight: 700;">$<?= number_format($d['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="padding-top: 30px;">
                    <div style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">ATENDIDO POR:</div>
                    <div style="font-family: var(--font-mono); font-size: 11px; font-weight: 700;"><?= strtoupper($factura['usuario_nombre']) ?></div>
                </td>
                <td style="padding-top: 30px; text-align: right; padding-right: 12px;">
                    <div style="font-family: var(--font-mono); font-size: 14px; font-weight: 700; color: var(--text-muted);">TOTAL A PAGAR:</div>
                </td>
                <td style="padding-top: 30px; text-align: right;">
                    <div style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; color: #15803d;">$<?= number_format($factura['total'], 2) ?></div>
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="border-top: 1px solid var(--border-color); padding-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        <div style="font-size: 11px; color: var(--text-muted); line-height: 1.6;">
            <strong>POLÍTICA DE GARANTÍA:</strong><br>
            Los productos industriales cuentan con 1 año de garantía por defectos de fábrica. Conserve esta factura para cualquier reclamación.
        </div>
        <div style="text-align: right; display: flex; flex-direction: column; justify-content: flex-end;">
            <div style="border-top: 1px solid #292524; width: 200px; margin-left: auto; padding-top: 5px; font-family: var(--font-mono); font-size: 9px; text-align: center; color: var(--text-muted); margin-top: 40px;">
                FIRMA AUTORIZADA / SELLO
            </div>
        </div>
    </div>

</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #invoice-printable, #invoice-printable * { visibility: visible; }
        #invoice-printable { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; border: none; }
        .section-header, .sidebar, .topbar, .tape { display: none !important; }
    }
</style>
