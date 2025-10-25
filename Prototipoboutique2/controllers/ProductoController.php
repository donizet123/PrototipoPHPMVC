<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/Session.php';

class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        Session::requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    // Listar todos los productos (Inventario)
    public function index() {
        $stmt = $this->producto->getAll();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../views/productos/index.php';
    }

    // Mostrar formulario de nuevo producto
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->codigo = trim($_POST['codigo']);
            $this->producto->nombre = trim($_POST['nombre']);
            $this->producto->descripcion = trim($_POST['descripcion']);
            $this->producto->precio = floatval($_POST['precio']);
            $this->producto->stock = intval($_POST['stock']);
            $this->producto->categoria = trim($_POST['categoria']);

            // Verificar si el código ya existe
            if ($this->producto->codigoExists($this->producto->codigo)) {
                Session::setFlash('error', 'El código ' . $this->producto->codigo . ' ya está en uso. Por favor usa otro código.');
                require_once __DIR__ . '/../views/productos/create.php';
                return;
            }

            try {
                if ($this->producto->create()) {
                    Session::setFlash('success', 'Producto agregado exitosamente');
                    header('Location: ' . BASE_URL . 'producto/index');
                    exit;
                } else {
                    Session::setFlash('error', 'Error al agregar el producto');
                }
            } catch (Exception $e) {
                Session::setFlash('error', 'Error: El código ya existe o hay un problema con los datos');
            }
        }
        
        require_once __DIR__ . '/../views/productos/create.php';
    }

    // Mostrar formulario de edición
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->id = $id;
            $this->producto->nombre = trim($_POST['nombre']);
            $this->producto->descripcion = trim($_POST['descripcion']);
            $this->producto->precio = floatval($_POST['precio']);
            $this->producto->stock = intval($_POST['stock']);
            $this->producto->categoria = trim($_POST['categoria']);

            if ($this->producto->update()) {
                Session::setFlash('success', 'Producto actualizado exitosamente');
                header('Location: ' . BASE_URL . 'producto/index');
                exit;
            } else {
                Session::setFlash('error', 'Error al actualizar el producto');
            }
        }

        $producto = $this->producto->getById($id);
        
        if (!$producto) {
            Session::setFlash('error', 'Producto no encontrado');
            header('Location: ' . BASE_URL . 'producto/index');
            exit;
        }

        require_once __DIR__ . '/../views/productos/edit.php';
    }

    // Eliminar producto
    public function delete($id) {
        if ($this->producto->delete($id)) {
            Session::setFlash('success', 'Producto eliminado exitosamente');
        } else {
            Session::setFlash('error', 'Error al eliminar el producto');
        }
        
        header('Location: ' . BASE_URL . 'producto/index');
        exit;
    }

    // Ver detalles de un producto
    public function view($id) {
        $producto = $this->producto->getById($id);
        
        if (!$producto) {
            Session::setFlash('error', 'Producto no encontrado');
            header('Location: ' . BASE_URL . 'producto/index');
            exit;
        }

        require_once __DIR__ . '/../views/productos/view.php';
    }
}
?>