<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>📋 Historial del Producto</h3>
            <div class="header-actions">
                <a href="<?php echo BASE_URL; ?>producto/view/<?php echo $producto['id']; ?>" class="btn btn-secondary">
                    👁️ Ver Producto
                </a>
                <a href="<?php echo BASE_URL; ?>historial/index" class="btn btn-secondary">
                    ← Volver
                </a>
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="producto-info">
            <div class="producto-detail">
                <strong>Código:</strong>
                <span><?php echo htmlspecialchars($producto['codigo']); ?></span>
            </div>
            <div class="producto-detail">
                <strong>Nombre:</strong>
                <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
            </div>
            <div class="producto-detail">
                <strong>Stock Actual:</strong>
                <span class="stock-badge"><?php echo $producto['stock']; ?> unidades</span>
            </div>
            <div class="producto-detail">
                <strong>Categoría:</strong>
                <span><?php echo htmlspecialchars($producto['categoria'] ?? 'Sin categoría'); ?></span>
            </div>
        </div>

        <?php if (count($movimientos) > 0): ?>
            <h4 style="margin: 30px 0 20px; color: #333;">Movimientos Registrados</h4>
            <div class="timeline">
                <?php foreach ($movimientos as $mov): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker <?php echo $mov['tipo_movimiento']; ?>">
                            <?php
                            $iconos = [
                                'entrada' => '📥',
                                'salida' => '📤',
                                'venta' => '💰',
                                'ajuste' => '⚙️'
                            ];
                            echo $iconos[$mov['tipo_movimiento']] ?? '•';
                            ?>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <span class="timeline-tipo <?php echo $mov['tipo_movimiento']; ?>">
                                    <?php
                                    $tipos = [
                                        'entrada' => 'Entrada',
                                        'salida' => 'Salida',
                                        'venta' => 'Venta',
                                        'ajuste' => 'Ajuste'
                                    ];
                                    echo $tipos[$mov['tipo_movimiento']] ?? '';
                                    ?>
                                </span>
                                <span class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($mov['created_at'])); ?>
                                </span>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-stats">
                                    <div class="stat-item">
                                        <small>Cantidad:</small>
                                        <strong class="cantidad-<?php echo $mov['tipo_movimiento']; ?>">
                                            <?php 
                                            if ($mov['tipo_movimiento'] == 'entrada') echo '+';
                                            if ($mov['tipo_movimiento'] == 'salida' || $mov['tipo_movimiento'] == 'venta') echo '-';
                                            echo $mov['cantidad']; 
                                            ?>
                                        </strong>
                                    </div>
                                    <div class="stat-item">
                                        <small>Stock anterior:</small>
                                        <strong><?php echo $mov['stock_anterior']; ?></strong>
                                    </div>
                                    <div class="stat-item destacado">
                                        <small>Stock nuevo:</small>
                                        <strong><?php echo $mov['stock_nuevo']; ?></strong>
                                    </div>
                                </div>
                                <?php if (!empty($mov['observaciones'])): ?>
                                    <div class="timeline-obs">
                                        <small>Observaciones:</small>
                                        <?php echo htmlspecialchars($mov['observaciones']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="timeline-usuario">
                                    Registrado por: <strong><?php echo htmlspecialchars($mov['usuario_nombre']); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h4>No hay movimientos registrados para este producto</h4>
                <p>El historial de movimientos aparecerá aquí</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.producto-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    margin-bottom: 20px;
}

.producto-detail {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.producto-detail strong {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.producto-detail span {
    font-size: 16px;
    color: #333;
}

.stock-badge {
    background: #F9C8C3;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 600;
    display: inline-block;
}

.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -40px;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.timeline-marker.entrada { background: #c8e6c9; }
.timeline-marker.salida { background: #ffe0b2; }
.timeline-marker.venta { background: #bbdefb; }
.timeline-marker.ajuste { background: #f3e5f5; }

.timeline-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid #e0e0e0;
}

.timeline-content:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateX(5px);
    transition: all 0.3s ease;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.timeline-tipo {
    font-weight: 600;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
}

.timeline-tipo.entrada {
    background: #c8e6c9;
    color: #2e7d32;
}

.timeline-tipo.salida {
    background: #ffe0b2;
    color: #e65100;
}

.timeline-tipo.venta {
    background: #bbdefb;
    color: #0d47a1;
}

.timeline-tipo.ajuste {
    background: #f3e5f5;
    color: #6a1b9a;
}

.timeline-fecha {
    color: #999;
    font-size: 13px;
}

.timeline-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.stat-item {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 6px;
}

.stat-item.destacado {
    background: #F9C8C3;
}

.stat-item small {
    display: block;
    font-size: 11px;
    color: #666;
    margin-bottom: 5px;
}

.stat-item strong {
    font-size: 18px;
    color: #333;
}

.cantidad-entrada {
    color: #4caf50;
}

.cantidad-salida,
.cantidad-venta {
    color: #ff5722;
}

.cantidad-ajuste {
    color: #9c27b0;
}

.timeline-obs {
    background: #fff9c4;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 14px;
}

.timeline-obs small {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

.timeline-usuario {
    font-size: 12px;
    color: #999;
    margin-top: 10px;
}

@media (max-width: 768px) {
    .timeline {
        padding-left: 30px;
    }
    
    .timeline-marker {
        width: 30px;
        height: 30px;
        font-size: 16px;
    }
    
    .timeline-stats {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>