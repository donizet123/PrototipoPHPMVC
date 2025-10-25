<?php 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="content-section">
    <?php if (Session::getFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars(Session::getFlash('success') ?? ''); ?>
        </div>
    <?php endif; ?>

    <?php if (Session::getFlash('error')): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars(Session::getFlash('error') ?? ''); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Inventario de Productos</h3>
            <a href="<?php echo BASE_URL; ?>producto/create" class="btn btn-primary">
                ➕ Nuevo Producto
            </a>
        </div>

        <?php if (count($productos) > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($producto['codigo'] ?? ''); ?></strong></td>
                                <td><?php echo htmlspecialchars($producto['nombre'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($producto['categoria'] ?? 'Sin categoría'); ?></td>
                                <td>S/ <?php echo number_format($producto['precio'] ?? 0, 2); ?></td>
                                <td>
                                    <span class="badge-stock <?php echo ($producto['stock'] ?? 0) <= 10 ? 'badge-low' : 'badge-ok'; ?>">
                                        <?php echo $producto['stock'] ?? 0; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (($producto['stock'] ?? 0) > 10): ?>
                                        <span class="badge badge-success">Disponible</span>
                                    <?php elseif (($producto['stock'] ?? 0) > 0): ?>
                                        <span class="badge badge-warning">Stock Bajo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Agotado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="<?php echo BASE_URL; ?>producto/view/<?php echo $producto['id']; ?>" 
                                       class="btn-action btn-view" title="Ver">
                                        👁️
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>producto/edit/<?php echo $producto['id']; ?>" 
                                       class="btn-action btn-edit" title="Editar">
                                        ✏️
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>producto/delete/<?php echo $producto['id']; ?>" 
                                       class="btn-action btn-delete" 
                                       title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        🗑️
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h4>No hay productos en el inventario</h4>
                <p>Agrega tu primer producto para comenzar</p>
                <a href="<?php echo BASE_URL; ?>producto/create" class="btn btn-primary">
                    ➕ Agregar Producto
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.card-header h3 {
    margin: 0;
    color: #333;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: #F9C8C3;
    color: #333;
}

.btn-primary:hover {
    background: #f7b5ae;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(249, 200, 195, 0.4);
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th {
    background: #F9C8C3;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #333;
}

.table td {
    padding: 15px;
    border-bottom: 1px solid #F5F5F5;
}

.table tr:hover {
    background: #FAFAFA;
}

.badge {
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #c8e6c9;
    color: #2e7d32;
}

.badge-warning {
    background: #fff9c4;
    color: #f57f17;
}

.badge-danger {
    background: #ffcdd2;
    color: #c62828;
}

.badge-stock {
    padding: 5px 12px;
    border-radius: 6px;
    font-weight: 600;
}

.badge-ok {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-low {
    background: #fff9c4;
    color: #f57f17;
}

.actions {
    white-space: nowrap;
}

.btn-action {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 3px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 16px;
    transition: all 0.3s ease;
}

.btn-view {
    background: #e3f2fd;
}

.btn-view:hover {
    background: #bbdefb;
    transform: scale(1.1);
}

.btn-edit {
    background: #fff9c4;
}

.btn-edit:hover {
    background: #fff59d;
    transform: scale(1.1);
}

.btn-delete {
    background: #ffcdd2;
}

.btn-delete:hover {
    background: #ef9a9a;
    transform: scale(1.1);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #c8e6c9;
    color: #2e7d32;
    border-left: 4px solid #2e7d32;
}

.alert-error {
    background: #ffcdd2;
    color: #c62828;
    border-left: 4px solid #c62828;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    font-size: 60px;
    margin-bottom: 15px;
}

.empty-state h4 {
    color: #666;
    margin-bottom: 10px;
}

.empty-state p {
    color: #999;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .table {
        font-size: 14px;
    }
    
    .table th,
    .table td {
        padding: 10px;
    }
    
    .card-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>