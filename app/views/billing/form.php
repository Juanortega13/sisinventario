<?php
// billing/form.php
?>
<div class="section-header">
    <h1 style="font-family: var(--font-mono); font-size: 24px; font-weight: 700; text-transform: uppercase;">
        Nueva Factura
    </h1>
    <a href="index.php?route=billing" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px;">
    
    <!-- Billing Panel -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Header Info -->
        <div class="card">
            <div class="card-title"><i class="fas fa-user"></i> Datos del Cliente</div>
            <div class="fg">
                <input type="text" id="cliente_nombre" placeholder="Nombre completo del cliente" 
                    style="width: 100%; padding: 14px; border: 1.5px solid var(--border-color); border-radius: 2px; font-family: var(--font-main); outline: none; font-size: 16px;">
            </div>
        </div>

        <!-- Items Table -->
        <div class="card" style="min-height: 400px; display: flex; flex-direction: column;">
            <div class="card-title"><i class="fas fa-list"></i> Detalle de Productos</div>
            <div class="table-container" style="flex: 1;">
                <table id="billing-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th style="width: 100px; text-align: center;">Cantidad</th>
                            <th style="width: 120px; text-align: right;">Precio</th>
                            <th style="width: 120px; text-align: right;">Subtotal</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody id="billing-body">
                        <!-- Items will be added here -->
                    </tbody>
                </table>
                <div id="no-items" style="padding: 60px; text-align: center; color: var(--text-muted); font-style: italic;">
                    No hay productos agregados a la factura.
                </div>
            </div>
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--bg-sidebar); display: flex; justify-content: flex-end; align-items: center; gap: 40px;">
                <div style="text-align: right;">
                    <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Total de Venta</div>
                    <div id="grand-total" style="font-size: 32px; font-weight: 700; font-family: var(--font-mono); color: #15803d;">$0.00</div>
                </div>
                <button id="btn-save-invoice" class="btn btn-primary" style="padding: 16px 40px; border-radius: 0;">
                    <i class="fas fa-save" style="margin-right: 10px;"></i> PROCESAR FACTURA
                </button>
            </div>
        </div>

    </div>

    <!-- Product Selection Sidebar -->
    <div class="card" style="position: sticky; top: 84px; height: calc(100vh - 120px); overflow-y: auto;">
        <div class="card-title"><i class="fas fa-search"></i> Catálogo de Productos</div>
        
        <div style="margin-bottom: 20px;">
            <input type="text" id="search-product" placeholder="Buscar..." 
                style="width: 100%; padding: 10px; border: 1px solid var(--border-color); font-size: 13px; font-family: var(--font-main);">
        </div>

        <div id="product-list" style="display: flex; flex-direction: column; gap: 10px;">
            <?php foreach($productos as $p): ?>
                <div class="product-item" 
                     data-id="<?= $p['id'] ?>" 
                     data-nombre="<?= $p['nombre'] ?>" 
                     data-precio="<?= $p['precio'] ?>"
                     data-stock="<?= $p['stock'] ?>"
                     style="padding: 12px; border: 1px solid var(--border-color); cursor: pointer; transition: all .2s; background: <?= $p['stock'] <= 0 ? '#fee2e2' : '#faf8f5' ?>;">
                    <div style="font-weight: 700; font-size: 13px;"><?= $p['nombre'] ?></div>
                    <div style="display: flex; justify-content: space-between; margin-top: 6px;">
                        <span style="font-family: var(--font-mono); font-size: 12px; font-weight: 700; color: #15803d;">$<?= number_format($p['precio'], 2) ?></span>
                        <span style="font-size: 11px; color: <?= $p['stock'] <= 0 ? '#dc2626' : 'var(--text-muted)' ?>;">
                            Stock: <?= $p['stock'] ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- MODAL STOCK -->
    <div id="stock-modal" style="
        position: fixed;
        inset: 0;
        background: rgba(12, 10, 9, 0.85);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    ">
        <div style="
            background: #1c1917;
            border: 1px solid #44403c;
            border-top: 4px solid #d97706;
            width: 90%;
            max-width: 400px;
            padding: 40px 30px;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        ">
            <!-- Decorative bolt -->
            <div style="position: absolute; top: 10px; right: 10px; opacity: 0.2;">
                <i class="fas fa-exclamation-triangle" style="color: #d97706; font-size: 20px;"></i>
            </div>

            <div style="text-align: center;">
                <div style="
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 60px;
                    height: 60px;
                    background: rgba(217, 119, 6, 0.1);
                    border-radius: 50%;
                    margin-bottom: 24px;
                ">
                    <i class="fas fa-boxes" style="color: #d97706; font-size: 24px;"></i>
                </div>

                <h3 style="
                    color: #faf8f5;
                    font-family: var(--font-mono);
                    font-size: 18px;
                    font-weight: 700;
                    letter-spacing: 2px;
                    text-transform: uppercase;
                    margin-bottom: 12px;
                ">Stock Agotado</h3>

                <p id="stock-message" style="
                    color: #a8a29e;
                    font-size: 15px;
                    line-height: 1.6;
                    margin-bottom: 32px;
                "></p>

                <button onclick="closeStockModal()" style="
                    width: 100%;
                    padding: 14px;
                    background: #d97706;
                    border: none;
                    color: #292524;
                    font-family: var(--font-mono);
                    font-weight: 700;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    cursor: pointer;
                    transition: all 0.2s;
                " onmouseover="this.style.background='#b45309'" onmouseout="this.style.background='#d97706'">
                    Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const items = [];
    const productList = document.querySelectorAll('.product-item');
    const billingBody = document.getElementById('billing-body');
    const noItemsLabel = document.getElementById('no-items');
    const grandTotalLabel = document.getElementById('grand-total');
    const searchInput = document.getElementById('search-product');

    // Search functionality
    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        productList.forEach(item => {
            const name = item.dataset.nombre.toLowerCase();
            item.style.display = name.includes(term) ? 'block' : 'none';
        });
    });

    // Add to invoice
    productList.forEach(item => {
        item.addEventListener('click', () => {
            const id = parseInt(item.dataset.id);
            const nombre = item.dataset.nombre;
            const precio = parseFloat(item.dataset.precio);
            const stock = parseInt(item.dataset.stock);

            if (stock <= 0) {
                showStockModal(nombre);
                return;
            }

            // Check if already in list
            const existing = items.find(i => i.id_producto === id);
            if (existing) {
                if (existing.cantidad < stock) {
                    existing.cantidad++;
                    renderItems();
                } else {
                    showStockModal(nombre);
                }
            } else {
                items.push({
                    id_producto: id,
                    producto_nombre: nombre,
                    cantidad: 1,
                    precio_unitario: precio,
                    subtotal: precio,
                    stock: stock
                });
                renderItems();
            }
        });
    });

    function renderItems() {
        if (items.length === 0) {
            billingBody.innerHTML = '';
            noItemsLabel.style.display = 'block';
            grandTotalLabel.innerText = '$0.00';
            return;
        }

        noItemsLabel.style.display = 'none';
        billingBody.innerHTML = '';
        let total = 0;

        items.forEach((item, index) => {
            item.subtotal = item.cantidad * item.precio_unitario;
            total += item.subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><div style="font-weight: 700;">${item.producto_nombre}</div></td>
                <td style="text-align: center;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <button onclick="updateQty(${index}, -1)" style="padding: 2px 8px; cursor: pointer;">-</button>
                        <span style="font-family: var(--font-mono); font-weight: 700;">${item.cantidad}</span>
                        <button onclick="updateQty(${index}, 1)" style="padding: 2px 8px; cursor: pointer;">+</button>
                    </div>
                </td>
                <td style="text-align: right; font-family: var(--font-mono);">$${item.precio_unitario.toFixed(2)}</td>
                <td style="text-align: right; font-family: var(--font-mono); font-weight: 700;">$${item.subtotal.toFixed(2)}</td>
                <td style="text-align: center;">
                    <button onclick="removeItem(${index})" style="color: #dc2626; border: none; background: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                </td>
            `;
            billingBody.appendChild(tr);
        });

        grandTotalLabel.innerText = `$${total.toFixed(2)}`;
    }

    window.updateQty = (index, delta) => {
        const item = items[index];
        const newQty = item.cantidad + delta;
        
        if (newQty > 0 && newQty <= item.stock) {
            item.cantidad = newQty;
            renderItems();
        } else if (newQty > item.stock) {
            showStockModal(item.producto_nombre);
        }
    };

    window.removeItem = (index) => {
        items.splice(index, 1);
        renderItems();
    };

    // Save Invoice
    document.getElementById('btn-save-invoice').addEventListener('click', async () => {
        const cliente = document.getElementById('cliente_nombre').value.trim();
        
        if (!cliente) {
            alert('Por favor ingrese el nombre del cliente');
            return;
        }

        if (items.length === 0) {
            alert('Debe agregar al menos un producto');
            return;
        }

        const total = items.reduce((sum, item) => sum + item.subtotal, 0);

        const formData = new FormData();
        formData.append('cliente_nombre', cliente);
        formData.append('total', total);
        formData.append('items', JSON.stringify(items));

        try {
            const response = await fetch('index.php?route=billing/create', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Factura procesada con éxito');
                window.location.href = result.redirect;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un problema al procesar la factura');
        }
    });
    // ===== MODAL STOCK =====
        function showStockModal(nombre) {
        const modal = document.getElementById('stock-modal');
        const message = document.getElementById('stock-message');

        message.innerHTML = `Lamentamos informarte que el producto <strong style="color: #faf8f5;">${nombre}</strong> no tiene más unidades disponibles para agregar.`;
        modal.style.display = 'flex';
        }   

        function closeStockModal() {
            document.getElementById('stock-modal').style.display = 'none';
        }

        // Cerrar al hacer clic fuera
        document.getElementById('stock-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStockModal();
            }
        });
</script>

<style>
    .product-item:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,.05);
    }
    #billing-table th { padding: 8px 12px; }
    #billing-table td { padding: 12px; }
</style>
