<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card welcome-card">
        <h1>🎀 Bienvenido al sistema de la Boutique Via Bella</h1>
        <p>Hola, <strong><?php echo htmlspecialchars(Session::get('nombre')); ?></strong>. Gestiona tu inventario, productos y ventas de manera eficiente</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <h3 class="stat-number"><?php echo $totalProductos; ?></h3>
            <p class="stat-label">Productos en stock</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <h3 class="stat-number">S/ <?php echo number_format($ventasMes, 2); ?></h3>
            <p class="stat-label">Ventas del mes</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🔔</div>
            <h3 class="stat-number"><?php echo $productosBajoStock; ?></h3>
            <p class="stat-label">Productos por agotar</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <h3 class="stat-number"><?php echo $stockTotal; ?></h3>
            <p class="stat-label">Total en inventario</p>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 15px;">Accesos Rápidos</h3>
        <div class="quick-actions">
            <a href="<?php echo BASE_URL; ?>producto/index" class="quick-action-btn">
                <span>📦</span>
                <span>Ver Inventario</span>
            </a>
            <a href="<?php echo BASE_URL; ?>producto/create" class="quick-action-btn">
                <span>➕</span>
                <span>Nuevo Producto</span>
            </a>
            <a href="<?php echo BASE_URL; ?>historial/index" class="quick-action-btn">
                <span>📋</span>
                <span>Ver Historial</span>
            </a>
            <a href="<?php echo BASE_URL; ?>codigos/index" class="quick-action-btn">
                <span>🔢</span>
                <span>Códigos</span>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>