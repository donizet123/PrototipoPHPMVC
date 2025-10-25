<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>✏️ Editar Producto</h3>
            <a href="<?php echo BASE_URL; ?>producto/index" class="btn btn-secondary">
                ← Volver al Inventario
            </a>
        </div>

        <?php if (Session::getFlash('error')): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars(Session::getFlash('error')); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>producto/edit/<?php echo $producto['id']; ?>" class="form-producto">
            <div class="form-row">
                <div class="form-group">
                    <label for="codigo">Código del Producto</label>
                    <input type="text" 
                           id="codigo" 
                           value="<?php echo htmlspecialchars($producto['codigo']); ?>" 
                           disabled
                           class="input-disabled">
                    <small>El código no se puede modificar</small>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria">
                        <option value="">Seleccionar categoría</option>
                        <option value="Vestidos" <?php echo ($producto['categoria'] == 'Vestidos') ? 'selected' : ''; ?>>Vestidos</option>
                        <option value="Blusas" <?php echo ($producto['categoria'] == 'Blusas') ? 'selected' : ''; ?>>Blusas</option>
                        <option value="Faldas" <?php echo ($producto['categoria'] == 'Faldas') ? 'selected' : ''; ?>>Faldas</option>
                        <option value="Pantalones" <?php echo ($producto['categoria'] == 'Pantalones') ? 'selected' : ''; ?>>Pantalones</option>
                        <option value="Chaquetas" <?php echo ($producto['categoria'] == 'Chaquetas') ? 'selected' : ''; ?>>Chaquetas</option>
                        <option value="Accesorios" <?php echo ($producto['categoria'] == 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
                        <option value="Zapatos" <?php echo ($producto['categoria'] == 'Zapatos') ? 'selected' : ''; ?>>Zapatos</option>
                        <option value="Carteras" <?php echo ($producto['categoria'] == 'Carteras') ? 'selected' : ''; ?>>Carteras</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre del Producto *</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       value="<?php echo htmlspecialchars($producto['nombre']); ?>"
                       required
                       maxlength="100">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="precio">Precio (S/) *</label>
                    <input type="number" 
                           id="precio" 
                           name="precio" 
                           value="<?php echo htmlspecialchars($producto['precio']); ?>"
                           step="0.01" 
                           min="0"
                           required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="<?php echo htmlspecialchars($producto['stock']); ?>"
                           min="0"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          rows="4"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>
            </div>

            <div class="info-box">
                <strong>ℹ️ Información:</strong><br>
                Creado: <?php echo date('d/m/Y H:i', strtotime($producto['created_at'])); ?><br>
                Última actualización: <?php echo date('d/m/Y H:i', strtotime($producto['updated_at'])); ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    💾 Guardar Cambios
                </button>
                <a href="<?php echo BASE_URL; ?>producto/index" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.input-disabled {
    background: #f5f5f5 !important;
    color: #999 !important;
    cursor: not-allowed;
}

.info-box {
    background: #e3f2fd;
    padding: 15px;
    border-radius: 8px;
    margin: 20px 0;
    font-size: 13px;
    color: #1565c0;
    border-left: 4px solid #1976d2;
}
</style>

<script>
// Validación del formulario
document.querySelector('.form-producto').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    const precio = parseFloat(document.getElementById('precio').value);
    const stock = parseInt(document.getElementById('stock').value);
    
    if (!nombre) {
        alert('Por favor ingresa el nombre del producto');
        e.preventDefault();
        return false;
    }
    
    if (precio < 0) {
        alert('El precio no puede ser negativo');
        e.preventDefault();
        return false;
    }
    
    if (stock < 0) {
        alert('El stock no puede ser negativo');
        e.preventDefault();
        return false;
    }
    
    return confirm('¿Estás seguro de actualizar este producto?');
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>