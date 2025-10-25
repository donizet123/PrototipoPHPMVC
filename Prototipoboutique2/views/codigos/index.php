<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header">
            <h3>🔢 Sistema de Códigos de Producto</h3>
            <a href="<?php echo BASE_URL; ?>codigos/generar" class="btn btn-primary">
                🎲 Generar Código
            </a>
        </div>

        <div class="info-banner">
            <div class="info-icon">ℹ️</div>
            <div class="info-content">
                <h4>Sistema de Codificación Via Bella</h4>
                <p>Todos los productos utilizan el prefijo <strong>VB</strong> seguido de 3 dígitos. Cada categoría tiene un rango específico de códigos asignado.</p>
                <p><strong>Último código registrado:</strong> <span class="codigo-badge"><?php echo htmlspecialchars($ultimo_codigo); ?></span></p>
            </div>
        </div>

        <div class="categorias-grid">
            <?php foreach ($categorias_codigos as $cat): ?>
                <?php
                $stats = $stats_por_categoria[$cat['categoria']] ?? null;
                $total_productos = $stats ? $stats['total'] : 0;
                $stock_total = $stats ? $stats['stock_total'] : 0;
                ?>
                <div class="categoria-card" style="border-left-color: <?php echo $cat['color']; ?>">
                    <div class="categoria-header">
                        <div class="categoria-icono" style="background: <?php echo $cat['color']; ?>">
                            <?php echo $cat['icono']; ?>
                        </div>
                        <div class="categoria-info">
                            <h4><?php echo htmlspecialchars($cat['categoria']); ?></h4>
                            <span class="categoria-rango"><?php echo $cat['rango']; ?></span>
                        </div>
                    </div>
                    
                    <p class="categoria-descripcion">
                        <?php echo htmlspecialchars($cat['descripcion']); ?>
                    </p>

                    <div class="categoria-stats">
                        <div class="stat-mini">
                            <span class="stat-mini-label">Productos:</span>
                            <span class="stat-mini-value"><?php echo $total_productos; ?></span>
                        </div>
                        <div class="stat-mini">
                            <span class="stat-mini-label">Stock Total:</span>
                            <span class="stat-mini-value"><?php echo $stock_total; ?></span>
                        </div>
                    </div>

                    <div class="categoria-ejemplo">
                        <strong>Ejemplo:</strong> 
                        <?php 
                        $rango_partes = explode('-', $cat['rango']);
                        echo $rango_partes[0] . ', ' . str_replace('VB', 'VB0', $rango_partes[0]) . '...';
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="reglas-section">
            <h4>📋 Reglas del Sistema de Códigos</h4>
            <div class="reglas-grid">
                <div class="regla-card">
                    <div class="regla-numero">1</div>
                    <div class="regla-content">
                        <h5>Formato Estándar</h5>
                        <p>Todos los códigos siguen el formato: <code>VB###</code></p>
                        <small>Ejemplo: VB001, VB150, VB523</small>
                    </div>
                </div>

                <div class="regla-card">
                    <div class="regla-numero">2</div>
                    <div class="regla-content">
                        <h5>Rangos Fijos</h5>
                        <p>Cada categoría tiene un rango de 100 códigos</p>
                        <small>No mezclar categorías en los rangos</small>
                    </div>
                </div>

                <div class="regla-card">
                    <div class="regla-numero">3</div>
                    <div class="regla-content">
                        <h5>Códigos Únicos</h5>
                        <p>Cada código debe ser único en el sistema</p>
                        <small>No se permiten códigos duplicados</small>
                    </div>
                </div>

                <div class="regla-card">
                    <div class="regla-numero">4</div>
                    <div class="regla-content">
                        <h5>Orden Secuencial</h5>
                        <p>Usar códigos de forma secuencial dentro del rango</p>
                        <small>Facilita el control y organización</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="verificador-section">
            <h4>🔍 Verificar Disponibilidad de Código</h4>
            <div class="verificador-box">
                <input type="text" 
                       id="codigo-verificar" 
                       placeholder="Ej: VB050" 
                       maxlength="5"
                       class="input-verificar">
                <button onclick="verificarCodigo()" class="btn btn-secondary">
                    Verificar
                </button>
                <div id="resultado-verificacion"></div>
            </div>
        </div>
    </div>
</div>

<style>
.info-banner {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: linear-gradient(135deg, #F9C8C3 0%, #fad4d0 100%);
    border-radius: 10px;
    margin-bottom: 30px;
    align-items: flex-start;
}

.info-icon {
    font-size: 40px;
    flex-shrink: 0;
}

.info-content h4 {
    margin-bottom: 10px;
    color: #333;
}

.info-content p {
    color: #666;
    line-height: 1.6;
    margin-bottom: 8px;
}

.codigo-badge {
    background: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 700;
    color: #333;
}

.categorias-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.categoria-card {
    background: white;
    border: 2px solid #f0f0f0;
    border-left-width: 5px;
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
}

.categoria-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.categoria-header {
    display: flex;
    gap: 15px;
    align-items: flex-start;
    margin-bottom: 15px;
}

.categoria-icono {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.categoria-info h4 {
    margin: 0 0 5px 0;
    color: #333;
    font-size: 18px;
}

.categoria-rango {
    background: #f5f5f5;
    padding: 3px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #666;
}

.categoria-descripcion {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.categoria-stats {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding: 10px;
    background: #fafafa;
    border-radius: 6px;
}

.stat-mini {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.stat-mini-label {
    font-size: 11px;
    color: #999;
}

.stat-mini-value {
    font-size: 18px;
    font-weight: 700;
    color: #F9C8C3;
}

.categoria-ejemplo {
    font-size: 13px;
    color: #666;
    padding: 10px;
    background: #f0f0f0;
    border-radius: 6px;
}

.categoria-ejemplo strong {
    color: #333;
}

.reglas-section {
    margin-bottom: 30px;
}

.reglas-section h4 {
    margin-bottom: 20px;
    color: #333;
}

.reglas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.regla-card {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    border-left: 4px solid #F9C8C3;
}

.regla-numero {
    width: 40px;
    height: 40px;
    background: #F9C8C3;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    color: #333;
    flex-shrink: 0;
}

.regla-content h5 {
    margin: 0 0 8px 0;
    color: #333;
    font-size: 16px;
}

.regla-content p {
    margin: 0 0 5px 0;
    color: #666;
    font-size: 14px;
}

.regla-content small {
    color: #999;
    font-size: 12px;
}

.regla-content code {
    background: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-family: monospace;
    color: #F9C8C3;
    font-weight: 600;
}

.verificador-section {
    background: #e3f2fd;
    padding: 25px;
    border-radius: 10px;
}

.verificador-section h4 {
    margin-bottom: 15px;
    color: #1565c0;
}

.verificador-box {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    flex-wrap: wrap;
}

.input-verificar {
    flex: 1;
    min-width: 200px;
    padding: 12px 15px;
    border: 2px solid #bbdefb;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    text-transform: uppercase;
}

#resultado-verificacion {
    flex-basis: 100%;
    margin-top: 10px;
    padding: 15px;
    border-radius: 8px;
    font-weight: 600;
    display: none;
}

#resultado-verificacion.disponible {
    background: #c8e6c9;
    color: #2e7d32;
    display: block;
}

#resultado-verificacion.ocupado {
    background: #ffcdd2;
    color: #c62828;
    display: block;
}

@media (max-width: 768px) {
    .categorias-grid {
        grid-template-columns: 1fr;
    }
    
    .reglas-grid {
        grid-template-columns: 1fr;
    }
    
    .verificador-box {
        flex-direction: column;
    }
    
    .input-verificar {
        width: 100%;
    }
}
</style>

<script>
function verificarCodigo() {
    const codigo = document.getElementById('codigo-verificar').value.trim().toUpperCase();
    const resultado = document.getElementById('resultado-verificacion');
    
    if (!codigo) {
        alert('Por favor ingresa un código');
        return;
    }
    
    if (!/^VB\d{3}$/.test(codigo)) {
        alert('Formato inválido. Usa el formato VB### (ej: VB001)');
        return;
    }
    
    fetch('<?php echo BASE_URL; ?>codigos/verificar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'codigo=' + encodeURIComponent(codigo)
    })
    .then(response => response.json())
    .then(data => {
        resultado.className = data.disponible ? 'disponible' : 'ocupado';
        resultado.textContent = data.disponible 
            ? `✅ El código ${codigo} está DISPONIBLE`
            : `❌ El código ${codigo} ya está en uso`;
    })
    .catch(error => {
        alert('Error al verificar el código');
        console.error(error);
    });
}

// Permitir Enter para verificar
document.getElementById('codigo-verificar').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        verificarCodigo();
    }
});

// Convertir a mayúsculas automáticamente
document.getElementById('codigo-verificar').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase();
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>