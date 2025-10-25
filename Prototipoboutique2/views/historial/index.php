<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <?php if (Session::getFlash('success')): ?>
        <div class="alert alert-success">
            <?php // CORRECCIÓN APLICADA AQUÍ (Línea 6) ?>
            <?php echo htmlspecialchars(Session::getFlash('success') ?? ''); ?>
        </div>
    <?php endif; ?>

    <?php if (Session::getFlash('error')): ?>
        <div class="alert alert-error">
            <?php // CORRECCIÓN APLICADA AQUÍ (Línea 11) ?>
            <?php echo htmlspecialchars(Session::getFlash('error') ?? ''); ?>
        </div>
    <?php endif; ?>

    <div class="stats-grid-historial">
        <div class="stat-card-small">
            <div class="stat-icon-small">📊</div>
            <div class="stat-content">
                <div class="stat-number-small"><?php echo $estadisticas['total_movimientos']; ?></div>
                <div class="stat-label-small">Total Movimientos</div>
            </div>
        </div>
        <div class="stat-card-small entrada">
            <div class="stat-icon-small">📥</div>
            <div class="stat-content">
                <div class="stat-number-small"><?php echo $estadisticas['total_entradas']; ?></div>
                <div class="stat-label-small">Entradas</div>
            </div>
        </div>
        <div class="stat-card-small salida">
            <div class="stat-icon-small">📤</div>
            <div class="stat-content">
                <div class="stat-number-small"><?php echo $estadisticas['total_salidas']; ?></div>
                <div class="stat-label-small">Salidas</div>
            </div>
        </div>
        <div class="stat-card-small venta">
            <div class="stat-icon-small">💰</div>
            <div class="stat-content">
                <div class="stat-number-small"><?php echo $estadisticas['total_ventas']; ?></div>
                <div class="stat-label-small">Ventas</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>📋 Historial de Movimientos</h3>
            <a href="<?php echo BASE_URL; ?>historial/registrar" class="btn btn-primary">
                ➕ Registrar Movimiento
            </a>
        </div>

        <div class="filtros">
            <form method="GET" action="<?php echo BASE_URL; ?>historial/index" class="filtros-form">
                <input type="text" 
                        name="buscar" 
                        placeholder="🔍 Buscar..." 
                        value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>"
                        class="input-buscar">
                
                <select name="tipo" class="select-filtro" onchange="this.form.submit()">
                    <option value="">Todos los tipos</option>
                    <option value="entrada" <?php echo ($_GET['tipo'] ?? '') == 'entrada' ? 'selected' : ''; ?>>📥 Entradas</option>
                    <option value="salida" <?php echo ($_GET['tipo'] ?? '') == 'salida' ? 'selected' : ''; ?>>📤 Salidas</option>
                    <option value="venta" <?php echo ($_GET['tipo'] ?? '') == 'venta' ? 'selected' : ''; ?>>💰 Ventas</option>
                    <option value="ajuste" <?php echo ($_GET['tipo'] ?? '') == 'ajuste' ? 'selected' : ''; ?>>⚙️ Ajustes</option>
                </select>

                <select name="dias" class="select-filtro" onchange="this.form.submit()">
                    <option value="">Todos los días</option>
                    <option value="1" <?php echo ($_GET['dias'] ?? '') == '1' ? 'selected' : ''; ?>>Hoy</option>
                    <option value="7" <?php echo ($_GET['dias'] ?? '') == '7' ? 'selected' : ''; ?>>Últimos 7 días</option>
                    <option value="30" <?php echo ($_GET['dias'] ?? '') == '30' ? 'selected' : ''; ?>>Últimos 30 días</option>
                </select>

                <?php if (!empty($_GET['buscar']) || !empty($_GET['tipo']) || !empty($_GET['dias'])): ?>
                    <a href="<?php echo BASE_URL; ?>historial/index" class="btn-limpiar">
                        ✖ Limpiar
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (count($movimientos) > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Stock Anterior</th>
                            <th>Stock Nuevo</th>
                            <th>Usuario</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $mov): ?>
                            <tr>
                                <td>
                                    <strong><?php echo date('d/m/Y', strtotime($mov['created_at'])); ?></strong><br>
                                    <small style="color: #999;"><?php echo date('H:i', strtotime($mov['created_at'])); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($mov['producto_codigo']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($mov['producto_nombre']); ?></small>
                                </td>
                                <td>
                                    <?php
                                    $badges = [
                                        'entrada' => ['📥 Entrada', 'badge-entrada'],
                                        'salida' => ['📤 Salida', 'badge-salida'],
                                        'venta' => ['💰 Venta', 'badge-venta'],
                                        'ajuste' => ['⚙️ Ajuste', 'badge-ajuste']
                                    ];
                                    $badge = $badges[$mov['tipo_movimiento']] ?? ['', ''];
                                    ?>
                                    <span class="badge <?php echo $badge[1]; ?>">
                                        <?php echo $badge[0]; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="cantidad">
                                        <?php 
                                        if ($mov['tipo_movimiento'] == 'entrada') {
                                            echo '+';
                                        } elseif ($mov['tipo_movimiento'] == 'salida' || $mov['tipo_movimiento'] == 'venta') {
                                            echo '-';
                                        }
                                        echo $mov['cantidad']; 
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo $mov['stock_anterior']; ?></td>
                                <td>
                                    <strong style="color: #F9C8C3;"><?php echo $mov['stock_nuevo']; ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($mov['usuario_nombre']); ?></td>
                                <td>
                                    <small><?php echo htmlspecialchars($mov['observaciones'] ?: '-'); ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h4>No hay registros en el historial</h4>
                <p>Los movimientos de inventario aparecerán aquí</p>
                <a href="<?php echo BASE_URL; ?>historial/registrar" class="btn btn-primary">
                    ➕ Registrar Primer Movimiento
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* ... Tu CSS se mantiene sin cambios ... */
.stats-grid-historial {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.stat-card-small {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-card-small.entrada { border-left: 4px solid #4caf50; }
.stat-card-small.salida { border-left: 4px solid #ff9800; }
.stat-card-small.venta { border-left: 4px solid #2196f3; }

.stat-icon-small {
    font-size: 30px;
}

.stat-number-small {
    font-size: 24px;
    font-weight: 700;
    color: #F9C8C3;
}

.stat-label-small {
    font-size: 12px;
    color: #666;
}

.filtros {
    margin-bottom: 20px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
}

.filtros-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.input-buscar,
.select-filtro {
    padding: 10px 15px;
    border: 2px solid #f0f0f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
}

.input-buscar {
    flex: 1;
    min-width: 200px;
}

.select-filtro {
    min-width: 150px;
}

.btn-limpiar {
    padding: 10px 20px;
    background: #ffebee;
    color: #c62828;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.btn-limpiar:hover {
    background: #ffcdd2;
}

.badge-entrada {
    background: #c8e6c9;
    color: #2e7d32;
}

.badge-salida {
    background: #ffe0b2;
    color: #e65100;
}

.badge-venta {
    background: #bbdefb;
    color: #0d47a1;
}

.badge-ajuste {
    background: #f3e5f5;
    color: #6a1b9a;
}

.cantidad {
    font-weight: 700;
    font-size: 16px;
}

@media (max-width: 768px) {
    .stats-grid-historial {
        grid-template-columns: 1fr;
    }
    
    .filtros-form {
        flex-direction: column;
    }
    
    .input-buscar,
    .select-filtro {
        width: 100%;
    }
    
    .table {
        font-size: 12px;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>