<?php
require_once '../config/database.php';

echo "<h2>🔍 Diagnóstico de Login</h2>";

// Probar conexión
try {
    $database = new Database();
    $db = $database->getConnection();
    echo "✅ Conexión a BD exitosa<br><br>";
} catch(Exception $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// Verificar usuario
$query = "SELECT * FROM usuarios WHERE usuario = 'admin'";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Usuario 'admin' encontrado en la BD<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Nombre: " . $user['nombre'] . "<br>";
    echo "Hash guardado: " . substr($user['password'], 0, 20) . "...<br><br>";
    
    // Probar password
    $password_test = "1234";
    if (password_verify($password_test, $user['password'])) {
        echo "✅ <strong style='color: green;'>PASSWORD '1234' ES CORRECTO!</strong><br><br>";
    } else {
        echo "❌ <strong style='color: red;'>PASSWORD '1234' NO COINCIDE</strong><br>";
        echo "El hash puede estar mal. Actualízalo con este SQL:<br>";
        echo "<textarea style='width:100%; height:80px;'>";
        echo "UPDATE usuarios SET password = '" . password_hash('1234', PASSWORD_DEFAULT) . "' WHERE usuario = 'admin';";
        echo "</textarea><br>";
    }
} else {
    echo "❌ Usuario 'admin' NO existe en la BD<br>";
    echo "Ejecuta este SQL en phpMyAdmin:<br>";
    echo "<textarea style='width:100%; height:100px;'>";
    echo "INSERT INTO usuarios (usuario, password, nombre, email, rol) VALUES ('admin', '" . password_hash('1234', PASSWORD_DEFAULT) . "', 'Administrador', 'admin@viabella.com', 'admin');";
    echo "</textarea>";
}
?>

<hr>
<h3>Ahora prueba el login:</h3>
<form method="POST" action="../auth/login">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" value="admin"><br><br>
    <label>Contraseña:</label><br>
    <input type="password" name="password" value="1234"><br><br>
    <button type="submit">Probar Login</button>
</form>
```

