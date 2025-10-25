<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "✅ Conexión exitosa a la base de datos<br>";
    
    // Verificar usuario
    $query = "SELECT * FROM usuarios WHERE usuario = 'admin'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "✅ Usuario 'admin' encontrado<br>";
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Datos: " . print_r($user, true);
    } else {
        echo "❌ Usuario 'admin' NO encontrado";
    }
} else {
    echo "❌ Error de conexión a la base de datos";
}
?>