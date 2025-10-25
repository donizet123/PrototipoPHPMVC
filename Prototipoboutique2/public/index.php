<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config/config.php';

Session::start();

// Obtener la URL solicitada
$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Determinar controlador y método
$controllerName = ucfirst($url[0]) . 'Controller';
$method = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Ruta del archivo del controlador
$controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            echo "Método '$method' no encontrado en el controlador '$controllerName'";
        }
    } else {
        echo "Clase '$controllerName' no encontrada";
    }
} else {
    echo "Controlador '$controllerName' no encontrado";
}
?>