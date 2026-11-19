<?php
// inventory/list.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Inventario de Productos
    </h1>
    <a href="<?= BASE_URL ?>index.php?route=inventory/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Añadir Producto
    </a>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th style="text-align: right;">Precio</th>
                    <th style="text-align: center;">Stock</th>
                    <th style="text-align: center;">Estado</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $p): ?>
                <tr>
                    <td>
                        <div style="font-weight: 700;"><?= $p['nombre'] ?></div>
                    </td>
                    <td style="font-size: 13px; color: var(--text-muted); max-width: 300px;"><?= $p['descripcion'] ?></td>
                    <td style="text-align: right; font-family: var(--font-mono); font-weight: 700;">
                        $<?= number_format($p['precio'], 2) ?>
                    </td>
                    <td style="text-align: center;">
                        <span style="font-family: var(--font-mono); font-weight: 700; font-size: 16px;">
                            <?= $p['stock'] ?>
                        </span>
                        <div style="font-size: 10px; color: var(--text-muted);">Mín: <?= $p['stock_minimo'] ?></div>
                    </td>
                    <td style="text-align: center;">
                        <?php if ($p['estado'] === 'disponible'): ?>
                            <span class="badge badge-success">Disponible</span>
                        <?php elseif ($p['estado'] === 'bajo_stock'): ?>
                            <span class="badge badge-warning">Bajo Stock</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Agotado</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="<?= BASE_URL ?>index.php?route=inventory/edit&id=<?= $p['id'] ?>" class="btn" style="padding: 6px 10px; background: #f5f0ea; color: var(--bg-sidebar);" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete(<?= $p['id'] ?>)" class="btn" style="padding: 6px 10px; background: rgba(220,38,38,.1); color: #dc2626;" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        window.location.href = '<?= BASE_URL ?>index.php?route=inventory/delete&id=' + id;
    }
}
</script>
