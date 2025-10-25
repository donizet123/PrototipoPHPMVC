<?php
$password = "1234";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Generador de Hash</h2>";
echo "Contraseña: <strong>$password</strong><br>";
echo "Hash generado: <strong>$hash</strong><br><br>";

echo "<h3>Copia este SQL y ejecútalo en phpMyAdmin:</h3>";
echo "<textarea style='width:100%; height:100px;'>";
echo "UPDATE usuarios SET password = '$hash' WHERE usuario = 'admin';";
echo "</textarea>";
?>