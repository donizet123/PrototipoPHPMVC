<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Historial.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/Session.php';

class HistorialController {
    private $db;
    private $historial;
    private $producto;

    public function __construct() {
        Session::requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->historial = new Historial($this->db);
        $this->producto = new Producto($this->db);
    }

    // Ver todo el historial
    public function index() {
        // Obtener filtros
        $filtro_tipo = $_GET['tipo'] ?? '';
        $filtro_dias = $_GET['dias'] ?? '';
        $buscar = $_GET['buscar'] ?? '';

        // Aplicar filtros
        if (!empty($buscar)) {
            $stmt = $this->historial->buscar($buscar);
        } elseif (!empty($filtro_tipo)) {
            $stmt = $this->historial->getByTipo($filtro_tipo);
        } elseif (!empty($filtro_dias)) {
            $stmt = $this->historial->getRecientes(intval($filtro_dias));
        } else {
            $stmt = $this->historial->getAll();
        }

        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $estadisticas = $this->historial->getEstadisticas();
        
        require_once __DIR__ . '/../views/historial/index.php';
    }

    // Registrar un nuevo movimiento
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = intval($_POST['producto_id']);
            $tipo_movimiento = trim($_POST['tipo_movimiento']);
            $cantidad = intval($_POST['cantidad']);
            $observaciones = trim($_POST['observaciones']);

            // Obtener producto actual
            $producto = $this->producto->getById($producto_id);
            
            if (!$producto) {
                Session::setFlash('error', 'Producto no encontrado');
                header('Location: ' . BASE_URL . 'historial/index');
                exit;
            }

            $stock_anterior = $producto['stock'];
            
            // Calcular nuevo stock según tipo de movimiento
            switch ($tipo_movimiento) {
                case 'entrada':
                    $stock_nuevo = $stock_anterior + $cantidad;
                    break;
                case 'salida':
                case 'venta':
                    $stock_nuevo = $stock_anterior - $cantidad;
                    if ($stock_nuevo < 0) {
                        Session::setFlash('error', 'No hay suficiente stock para esta operación');
                        header('Location: ' . BASE_URL . 'historial/registrar');
                        exit;
                    }
                    break;
                case 'ajuste':
                    $stock_nuevo = $cantidad; // El ajuste establece un stock específico
                    $cantidad = abs($stock_nuevo - $stock_anterior);
                    break;
                default:
                    Session::setFlash('error', 'Tipo de movimiento inválido');
                    header('Location: ' . BASE_URL . 'historial/registrar');
                    exit;
            }

            // Actualizar stock del producto
            $this->producto->id = $producto_id;
            $this->producto->stock = $stock_nuevo;
            $this->producto->nombre = $producto['nombre'];
            $this->producto->descripcion = $producto['descripcion'];
            $this->producto->precio = $producto['precio'];
            $this->producto->categoria = $producto['categoria'];

            if ($this->producto->update()) {
                // Registrar en historial
                $this->historial->producto_id = $producto_id;
                $this->historial->usuario_id = Session::get('user_id');
                $this->historial->tipo_movimiento = $tipo_movimiento;
                $this->historial->cantidad = $cantidad;
                $this->historial->stock_anterior = $stock_anterior;
                $this->historial->stock_nuevo = $stock_nuevo;
                $this->historial->observaciones = $observaciones;

                if ($this->historial->create()) {
                    Session::setFlash('success', 'Movimiento registrado exitosamente');
                    header('Location: ' . BASE_URL . 'historial/index');
                    exit;
                }
            }

            Session::setFlash('error', 'Error al registrar el movimiento');
        }

        // Obtener todos los productos para el select
        $stmt = $this->producto->getAll();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/historial/registrar.php';
    }

    // Ver historial de un producto específico
    public function producto($id) {
        $producto = $this->producto->getById($id);
        
        if (!$producto) {
            Session::setFlash('error', 'Producto no encontrado');
            header('Location: ' . BASE_URL . 'historial/index');
            exit;
        }

        $stmt = $this->historial->getByProducto($id);
        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/historial/producto.php';
    }
}
?>