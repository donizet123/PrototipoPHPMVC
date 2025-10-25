<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>👁️ Detalles del Producto</h3>
            <div class="header-actions">
                <a href="<?php echo BASE_URL; ?>producto/edit/<?php echo $producto['id']; ?>" class="btn btn-primary">
                    ✏️ Editar
                </a>
                <a href="<?php echo BASE_URL; ?>producto/index" class="btn btn-secondary">
                    ← Volver
                </a>
            </div>
        </div>

        <div class="product-details">
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Código:</label>
                    <div class="detail-value highlight"><?php echo htmlspecialchars($producto['codigo']); ?></div>
                </div>

                <div class="detail-item">
                    <label>Estado:</label>
                    <div class="detail-value">
                        <?php if ($producto['stock'] > 10): ?>
                            <span class="badge badge-success">✅ Disponible</span>
                        <?php elseif ($producto['stock'] > 0): ?>
                            <span class="badge badge-warning">⚠️ Stock Bajo</span>
                        <?php else: ?>
                            <span class="badge badge-danger">❌ Agotado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-item full-width">
                    <label>Nombre del Producto:</label>
                    <div class="detail-value"><?php echo htmlspecialchars($producto['nombre']); ?></div>
                </div>

                <div class="detail-item">
                    <label>Categoría:</label>
                    <div class="detail-value"><?php echo htmlspecialchars($producto['categoria'] ?? 'Sin categoría'); ?></div>
                </div>

                <div class="detail-item">
                    <label>Precio:</label>
                    <div class="detail-value price">S/ <?php echo number_format($producto['precio'], 2); ?></div>
                </div>

                <div class="detail-item">
                    <label>Stock Disponible:</label>
                    <div class="detail-value stock">
                        <span class="stock-number"><?php echo $producto['stock']; ?></span> unidades
                    </div>
                </div>

                <div class="detail-item">
                    <label>Valor Total en Stock:</label>
                    <div class="detail-value price">S/ <?php echo number_format($producto['precio'] * $producto['stock'], 2); ?></div>
                </div>

                <?php if (!empty($producto['descripcion'])): ?>
                <div class="detail-item full-width">
                    <label>Descripción:</label>
                    <div class="detail-value description"><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></div>
                </div>
                <?php endif; ?>

                <div class="detail-item">
                    <label>Fecha de Creación:</label>
                    <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($producto['created_at'])); ?></div>
                </div>

                <div class="detail-item">
                    <label>Última Actualización:</label>
                    <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($producto['updated_at'])); ?></div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="<?php echo BASE_URL; ?>producto/edit/<?php echo $producto['id']; ?>" class="btn btn-primary">
                ✏️ Editar Producto
            </a>
            <a href="<?php echo BASE_URL; ?>historial/producto/<?php echo $producto['id']; ?>" class="btn btn-info">
                📋 Ver Historial
            </a>
            <a href="<?php echo BASE_URL; ?>producto/delete/<?php echo $producto['id']; ?>" 
               class="btn btn-danger"
               onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                🗑️ Eliminar Producto
            </a>
        </div>
    </div>
</div>

<style>
.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.product-details {
    background: #f9f9f9;
    padding: 30px;
    border-radius: 10px;
    margin: 20px 0;
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-weight: 600;
    color: #666;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    background: white;
    padding: 12px 15px;
    border-radius: 8px;
    border: 2px solid #f0f0f0;
    font-size: 15px;
    color: #333;
}

.detail-value.highlight {
    background: #F9C8C3;
    color: #333;
    font-weight: 700;
    font-size: 18px;
}

.detail-value.price {
    color: #2e7d32;
    font-weight: 700;
    font-size: 18px;
}

.detail-value.stock {
    font-size: 16px;
}

.stock-number {
    font-weight: 700;
    color: #F9C8C3;
    font-size: 20px;
}

.detail-value.description {
    min-height: 60px;
    line-height: 1.6;
}

.action-buttons {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
    margin-top: 20px;
}

.btn-danger {
    background: #ffcdd2;
    color: #c62828;
}

.btn-danger:hover {
    background: #ef9a9a;
    transform: translateY(-2px);
}

.btn-info {
    background: #bbdefb;
    color: #0d47a1;
}

.btn-info:hover {
    background: #90caf9;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .header-actions .btn {
        flex: 1;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>