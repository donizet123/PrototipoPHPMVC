<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-section">
                <div class="logo">
                    <img src="<?php echo BASE_URL; ?>logo.jpg" alt="Logo" onerror="this.parentElement.innerHTML='🎀'">
                </div>
                <div class="logo-text">Via Bella</div>
                <div class="logo-subtitle">Boutique</div>
            </div>

            <nav class="menu">
                <a href="<?php echo BASE_URL; ?>dashboard/index" class="menu-item <?php echo (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'active' : ''; ?>">
                    <span class="menu-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo BASE_URL; ?>producto/index" class="menu-item <?php echo (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'producto') !== false) ? 'active' : ''; ?>">
                    <span class="menu-icon">📦</span>
                    <span>Inventario</span>
                </a>
                <a href="<?php echo BASE_URL; ?>producto/create" class="menu-item">
                    <span class="menu-icon">➕</span>
                    <span>Nuevo Producto</span>
                </a>
                <a href="<?php echo BASE_URL; ?>historial/index" class="menu-item <?php echo (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'historial') !== false) ? 'active' : ''; ?>">
                    <span class="menu-icon">📋</span>
                    <span>Historial</span>
                </a>
                <a href="<?php echo BASE_URL; ?>codigos/index" class="menu-item <?php echo (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'codigos') !== false) ? 'active' : ''; ?>">
                    <span class="menu-icon">🔢</span>
                    <span>Códigos</span>
                </a>
            </nav>

            <a href="<?php echo BASE_URL; ?>auth/logout" class="logout">
                <span class="menu-icon">🚪</span>
                <span>Cerrar Sesión</span>
            </a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2 id="page-title">
                    <?php 
                    if (isset($_SERVER['REQUEST_URI'])) {
                        $uri = $_SERVER['REQUEST_URI'];
                        if (strpos($uri, 'dashboard') !== false) echo 'Dashboard';
                        elseif (strpos($uri, 'producto/create') !== false) echo 'Nuevo Producto';
                        elseif (strpos($uri, 'producto/edit') !== false) echo 'Editar Producto';
                        elseif (strpos($uri, 'producto/view') !== false) echo 'Ver Producto';
                        elseif (strpos($uri, 'producto') !== false) echo 'Inventario';
                        elseif (strpos($uri, 'historial') !== false) echo 'Historial';
                        elseif (strpos($uri, 'codigos') !== false) echo 'Códigos';
                        else echo 'Sistema';
                    } else {
                        echo 'Sistema';
                    }
                    ?>
                </h2>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr(Session::get('nombre'), 0, 1)); ?></div>
                    <span>Bienvenido, <strong><?php echo htmlspecialchars(Session::get('nombre')); ?></strong></span>
                </div>
            </div>