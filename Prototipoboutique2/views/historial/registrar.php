<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>➕ Registrar Movimiento de Inventario</h3>
            <a href="<?php echo BASE_URL; ?>historial/index" class="btn btn-secondary">
                ← Volver al Historial
            </a>
        </div>

        <?php if (Session::getFlash('error')): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars(Session::getFlash('error')); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>historial/registrar" class="form-movimiento" id="formMovimiento">
            <div class="form-row">
                <div class="form-group">
                    <label for="producto_id">Producto *</label>
                    <select id="producto_id" name="producto_id" required>
                        <option value="">Seleccionar producto</option>
                        <?php foreach ($productos as $prod): ?>
                            <option value="<?php echo $prod['id']; ?>" 
                                    data-stock="<?php echo $prod['stock']; ?>"
                                    data-codigo="<?php echo htmlspecialchars($prod['codigo']); ?>">
                                <?php echo htmlspecialchars($prod['codigo'] . ' - ' . $prod['nombre'] . ' (Stock: ' . $prod['stock'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small id="stock-actual" style="display: none; margin-top: 5px; color: #666;"></small>
                </div>

                <div class="form-group">
                    <label for="tipo_movimiento">Tipo de Movimiento *</label>
                    <select id="tipo_movimiento" name="tipo_movimiento" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="entrada">📥 Entrada (Aumenta stock)</option>
                        <option value="salida">📤 Salida (Reduce stock)</option>
                        <option value="venta">💰 Venta (Reduce stock)</option>
                        <option value="ajuste">⚙️ Ajuste (Establece stock exacto)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad *</label>
                <input type="number" 
                       id="cantidad" 
                       name="cantidad" 
                       placeholder="0" 
                       min="1"
                       required>
                <small id="help-cantidad">Ingresa la cantidad del movimiento</small>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" 
                          name="observaciones" 
                          rows="4" 
                          placeholder="Ej: Compra a proveedor, Devolución de cliente, Corrección de inventario..."></textarea>
            </div>

            <div class="preview-box" id="preview-box" style="display: none;">
                <h4>📊 Vista Previa del Movimiento</h4>
                <div class="preview-content">
                    <div class="preview-item">
                        <strong>Producto:</strong> <span id="prev-producto">-</span>
                    </div>
                    <div class="preview-item">
                        <strong>Tipo:</strong> <span id="prev-tipo">-</span>
                    </div>
                    <div class="preview-item">
                        <strong>Stock Actual:</strong> <span id="prev-stock-actual">0</span>
                    </div>
                    <div class="preview-item">
                        <strong>Cantidad:</strong> <span id="prev-cantidad">0</span>
                    </div>
                    <div class="preview-item destacado">
                        <strong>Stock Nuevo:</strong> <span id="prev-stock-nuevo">0</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="btnGuardar">
                    💾 Registrar Movimiento
                </button>
                <a href="<?php echo BASE_URL; ?>historial/index" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.form-movimiento {
    max-width: 800px;
}

.preview-box {
    background: #e3f2fd;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border-left: 4px solid #2196f3;
}

.preview-box h4 {
    margin-bottom: 15px;
    color: #1565c0;
}

.preview-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.preview-item {
    background: white;
    padding: 10px;
    border-radius: 6px;
}

.preview-item.destacado {
    background: #F9C8C3;
    font-size: 18px;
}

.preview-item strong {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.preview-item span {
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

#help-cantidad {
    display: block;
    margin-top: 5px;
    color: #666;
}
</style>

<script>
let stockActual = 0;

// Mostrar stock actual al seleccionar producto
document.getElementById('producto_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const stock = option.getAttribute('data-stock');
    const codigo = option.getAttribute('data-codigo');
    
    if (stock) {
        stockActual = parseInt(stock);
        document.getElementById('stock-actual').style.display = 'block';
        document.getElementById('stock-actual').textContent = `Stock actual: ${stockActual} unidades`;
        actualizarPreview();
    }
});

// Actualizar preview al cambiar tipo de movimiento
document.getElementById('tipo_movimiento').addEventListener('change', function() {
    const tipo = this.value;
    const helpText = document.getElementById('help-cantidad');
    
    switch(tipo) {
        case 'entrada':
            helpText.textContent = '➕ Esta cantidad se SUMARÁ al stock actual';
            helpText.style.color = '#4caf50';
            break;
        case 'salida':
        case 'venta':
            helpText.textContent = '➖ Esta cantidad se RESTARÁ del stock actual';
            helpText.style.color = '#ff9800';
            break;
        case 'ajuste':
            helpText.textContent = '⚙️ Esta será la cantidad EXACTA del nuevo stock';
            helpText.style.color = '#9c27b0';
            break;
        default:
            helpText.textContent = 'Ingresa la cantidad del movimiento';
            helpText.style.color = '#666';
    }
    
    actualizarPreview();
});

// Actualizar preview al cambiar cantidad
document.getElementById('cantidad').addEventListener('input', actualizarPreview);

function actualizarPreview() {
    const producto = document.getElementById('producto_id');
    const tipo = document.getElementById('tipo_movimiento').value;
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
    
    if (!producto.value || !tipo || cantidad === 0) {
        document.getElementById('preview-box').style.display = 'none';
        return;
    }
    
    const productoNombre = producto.options[producto.selectedIndex].text;
    let stockNuevo = stockActual;
    let tipoTexto = '';
    
    switch(tipo) {
        case 'entrada':
            stockNuevo = stockActual + cantidad;
            tipoTexto = '📥 Entrada';
            break;
        case 'salida':
            stockNuevo = stockActual - cantidad;
            tipoTexto = '📤 Salida';
            break;
        case 'venta':
            stockNuevo = stockActual - cantidad;
            tipoTexto = '💰 Venta';
            break;
        case 'ajuste':
            stockNuevo = cantidad;
            tipoTexto = '⚙️ Ajuste';
            break;
    }
    
    // Actualizar preview
    document.getElementById('prev-producto').textContent = productoNombre;
    document.getElementById('prev-tipo').textContent = tipoTexto;
    document.getElementById('prev-stock-actual').textContent = stockActual;
    document.getElementById('prev-cantidad').textContent = cantidad;
    document.getElementById('prev-stock-nuevo').textContent = stockNuevo;
    
    // Colorear según resultado
    const stockNuevoElement = document.getElementById('prev-stock-nuevo');
    if (stockNuevo < 0) {
        stockNuevoElement.style.color = '#c62828';
        stockNuevoElement.parentElement.style.background = '#ffcdd2';
    } else if (stockNuevo <= 10) {
        stockNuevoElement.style.color = '#f57f17';
        stockNuevoElement.parentElement.style.background = '#fff9c4';
    } else {
        stockNuevoElement.style.color = '#2e7d32';
        stockNuevoElement.parentElement.style.background = '#c8e6c9';
    }
    
    document.getElementById('preview-box').style.display = 'block';
}

// Validación antes de enviar
document.getElementById('formMovimiento').addEventListener('submit', function(e) {
    const tipo = document.getElementById('tipo_movimiento').value;
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
    
    let stockNuevo = stockActual;
    
    switch(tipo) {
        case 'salida':
        case 'venta':
            stockNuevo = stockActual - cantidad;
            if (stockNuevo < 0) {
                alert('❌ Error: No hay suficiente stock para esta operación.\n\nStock actual: ' + stockActual + '\nCantidad solicitada: ' + cantidad);
                e.preventDefault();
                return false;
            }
            break;
        case 'ajuste':
            stockNuevo = cantidad;
            break;
        case 'entrada':
            stockNuevo = stockActual + cantidad;
            break;
    }
    
    const confirmMsg = `¿Confirmas este movimiento?\n\n` +
                      `Producto: ${document.getElementById('producto_id').options[document.getElementById('producto_id').selectedIndex].text}\n` +
                      `Tipo: ${document.getElementById('tipo_movimiento').options[document.getElementById('tipo_movimiento').selectedIndex].text}\n` +
                      `Stock actual: ${stockActual}\n` +
                      `Cantidad: ${cantidad}\n` +
                      `Stock nuevo: ${stockNuevo}`;
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>