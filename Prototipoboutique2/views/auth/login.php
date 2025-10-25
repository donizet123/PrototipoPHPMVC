<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <div class="logo-placeholder">
                <img src="<?php echo BASE_URL; ?>logo.jpg" alt="Logo Via Bella" onerror="this.parentElement.innerHTML='🎀'">
            </div>
            <h1>Boutique Via Bella</h1>
            <p class="subtitle">Sistema de Gestión</p>
        </div>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (Session::getFlash('success')): ?>
            <div class="success-message">
                <?php echo htmlspecialchars(Session::getFlash('success')); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>auth/login">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <div class="demo-info">
            <strong>Demo:</strong> Usuario: admin | Contraseña: 1234
        </div>
    </div>
</body>
</html>