<?php
// inventory/form.php
$isEdit = isset($producto);
$title = $isEdit ? 'Editar Producto' : 'Añadir Producto';
$action = $isEdit ? 'index.php?route=inventory/edit&id=' . $producto['id'] : 'index.php?route=inventory/create';
?>

<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        <?= $title ?>
    </h1>
    <a href="index.php?route=inventory" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
</div>

<div style="max-width: 700px; margin: 0 auto;">
    <div class="card" style="padding: 0;">
        <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); padding: 12px 24px; border-bottom: 1px solid var(--border-color); background: #f5f0ea;">
            FICHA TÉCNICA DEL PRODUCTO
        </div>
        
        <form action="<?= $action ?>" method="POST" style="padding: 32px 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px;">
                        Nombre del Producto
                    </label>
                    <input type="text" name="nombre" value="<?= $producto['nombre'] ?? '' ?>" required
                        style="width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-main); outline: none;">
                </div>

                <div style="grid-column: span 2;">
                    <label style="display: block; font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px;">
                        Descripción / Especificaciones
                    </label>
                    <textarea name="descripcion" rows="3"
                        style="width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-main); outline: none; resize: vertical;"><?= $producto['descripcion'] ?? '' ?></textarea>
                </div>

                <div>
                    <label style="display: block; font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px;">
                        Precio Unitario ($)
                    </label>
                    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?? '' ?>" required
                        style="width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-mono); outline: none;">
                </div>

                <div>
                    <label style="display: block; font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px;">
                        Stock Actual (Unidades)
                    </label>
                    <input type="number" name="stock" value="<?= $producto['stock'] ?? '' ?>" required
                        style="width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-mono); outline: none;">
                </div>

                <div>
                    <label style="display: block; font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px;">
                        Stock Mínimo (Alerta)
                    </label>
                    <input type="number" name="stock_minimo" value="<?= $producto['stock_minimo'] ?? '5' ?>" required
                        style="width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-mono); outline: none;">
                </div>

            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 14px 40px; border-radius: 0;">
                    <i class="fas fa-save" style="margin-right: 10px;"></i>
                    <?= $isEdit ? 'Actualizar Producto' : 'Registrar Producto' ?>
                </button>
            </div>
        </form>
    </div>
</div>
