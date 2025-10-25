<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/Session.php';

class DashboardController {
    private $db;
    private $producto;

    public function __construct() {
        Session::requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    public function index() {
        // Obtener estadísticas
        $totalProductos = $this->producto->getTotalProductos();
        $stockTotal = $this->producto->getStockTotal();
        $productosBajoStock = $this->producto->getProductosBajoStock(10);
        
        // Datos simulados para ventas del mes (puedes crear un modelo Ventas después)
        $ventasMes = 3450;
        
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
?>