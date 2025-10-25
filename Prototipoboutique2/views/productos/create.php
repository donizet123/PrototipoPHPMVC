<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>➕ Agregar Nuevo Producto</h3>
            <a href="<?php echo BASE_URL; ?>producto/index" class="btn btn-secondary">
                ← Volver al Inventario
            </a>
        </div>

        <?php if (Session::getFlash('error')): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars(Session::getFlash('error') ?? ''); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>producto/create" class="form-producto">
            <div class="form-row">
                <div class="form-group">
                    <label for="codigo">Código del Producto *</label>
                    <input type="text" 
                           id="codigo" 
                           name="codigo" 
                           placeholder="Ej: VB007" 
                           required 
                           maxlength="20"
                           pattern="[A-Za-z0-9]+"
                           title="Solo letras y números"
                           value="<?php echo isset($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : ''; ?>">
                    <small>Solo letras y números, sin espacios</small>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria">
                        <option value="">Seleccionar categoría</option>
                        <option value="Vestidos" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Vestidos') ? 'selected' : ''; ?>>Vestidos</option>
                        <option value="Blusas" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Blusas') ? 'selected' : ''; ?>>Blusas</option>
                        <option value="Faldas" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Faldas') ? 'selected' : ''; ?>>Faldas</option>
                        <option value="Pantalones" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Pantalones') ? 'selected' : ''; ?>>Pantalones</option>
                        <option value="Chaquetas" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Chaquetas') ? 'selected' : ''; ?>>Chaquetas</option>
                        <option value="Accesorios" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
                        <option value="Zapatos" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Zapatos') ? 'selected' : ''; ?>>Zapatos</option>
                        <option value="Carteras" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Carteras') ? 'selected' : ''; ?>>Carteras</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre del Producto *</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       placeholder="Ej: Vestido Elegante de Noche" 
                       required
                       maxlength="100"
                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="precio">Precio (S/) *</label>
                    <input type="number" 
                           id="precio" 
                           name="precio" 
                           placeholder="0.00" 
                           step="0.01" 
                           min="0"
                           required
                           value="<?php echo isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="stock">Stock Inicial *</label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           placeholder="0" 
                           min="0"
                           required
                           value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          rows="4" 
                          placeholder="Descripción detallada del producto..."><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    💾 Guardar Producto
                </button>
                <a href="<?php echo BASE_URL; ?>producto/index" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.card-header-simple {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.card-header-simple h3 {
    margin: 0;
    color: #333;
}

.form-producto {
    max-width: 800px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #F5F5F5;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #F9C8C3;
    background: #FFFFFF;
}

.form-group small {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: #999;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #F5F5F5;
}

.btn-secondary {
    background: #F5F5F5;
    color: #333;
}

.btn-secondary:hover {
    background: #e0e0e0;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
    
    .card-header-simple {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<script>
// Validación del formulario
document.querySelector('.form-producto').addEventListener('submit', function(e) {
    const codigo = document.getElementById('codigo').value.trim();
    const nombre = document.getElementById('nombre').value.trim();
    const precio = parseFloat(document.getElementById('precio').value);
    const stock = parseInt(document.getElementById('stock').value);
    
    if (!codigo || !nombre) {
        alert('Por favor completa todos los campos obligatorios');
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
    
    return true;
});

// Convertir código a mayúsculas automáticamente
document.getElementById('codigo').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase();
});

// Verificar disponibilidad del código en tiempo real
let timeoutId;
document.getElementById('codigo').addEventListener('input', function(e) {
    clearTimeout(timeoutId);
    const codigo = this.value.trim().toUpperCase();
    const pequenoEl = this.parentElement.querySelector('small');
    
    if (codigo.length < 3) {
        pequenoEl.textContent = 'Solo letras y números, sin espacios';
        pequenoEl.style.color = '#999';
        return;
    }
    
    // Esperar 500ms después de que el usuario deje de escribir
    timeoutId = setTimeout(() => {
        fetch('<?php echo BASE_URL; ?>codigos/verificar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'codigo=' + encodeURIComponent(codigo)
        })
        .then(response => response.json())
        .then(data => {
            if (data.disponible) {
                pequenoEl.textContent = '✅ Código disponible';
                pequenoEl.style.color = '#4caf50';
            } else {
                pequenoEl.textContent = '❌ Este código ya está en uso';
                pequenoEl.style.color = '#f44336';
            }
        })
        .catch(error => {
            console.error('Error al verificar código:', error);
        });
    }, 500);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>