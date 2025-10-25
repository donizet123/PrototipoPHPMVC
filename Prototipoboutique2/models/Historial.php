<?php
class Historial {
    private $conn;
    private $table = "historial";

    public $id;
    public $producto_id;
    public $usuario_id;
    public $tipo_movimiento;
    public $cantidad;
    public $stock_anterior;
    public $stock_nuevo;
    public $observaciones;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todo el historial con información de productos y usuarios
    public function getAll($limit = 100) {
        $query = "SELECT 
                    h.*,
                    p.codigo as producto_codigo,
                    p.nombre as producto_nombre,
                    u.nombre as usuario_nombre
                  FROM " . $this->table . " h
                  LEFT JOIN productos p ON h.producto_id = p.id
                  LEFT JOIN usuarios u ON h.usuario_id = u.id
                  ORDER BY h.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener historial por producto
    public function getByProducto($producto_id, $limit = 50) {
        $query = "SELECT 
                    h.*,
                    u.nombre as usuario_nombre
                  FROM " . $this->table . " h
                  LEFT JOIN usuarios u ON h.usuario_id = u.id
                  WHERE h.producto_id = :producto_id
                  ORDER BY h.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener historial por tipo de movimiento
    public function getByTipo($tipo, $limit = 50) {
        $query = "SELECT 
                    h.*,
                    p.codigo as producto_codigo,
                    p.nombre as producto_nombre,
                    u.nombre as usuario_nombre
                  FROM " . $this->table . " h
                  LEFT JOIN productos p ON h.producto_id = p.id
                  LEFT JOIN usuarios u ON h.usuario_id = u.id
                  WHERE h.tipo_movimiento = :tipo
                  ORDER BY h.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Crear registro de historial
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (producto_id, usuario_id, tipo_movimiento, cantidad, stock_anterior, stock_nuevo, observaciones)
                  VALUES
                  (:producto_id, :usuario_id, :tipo_movimiento, :cantidad, :stock_anterior, :stock_nuevo, :observaciones)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':producto_id', $this->producto_id);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':tipo_movimiento', $this->tipo_movimiento);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':stock_anterior', $this->stock_anterior);
        $stmt->bindParam(':stock_nuevo', $this->stock_nuevo);
        $stmt->bindParam(':observaciones', $this->observaciones);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener estadísticas del historial
    public function getEstadisticas() {
        $query = "SELECT 
                    COUNT(*) as total_movimientos,
                    SUM(CASE WHEN tipo_movimiento = 'entrada' THEN cantidad ELSE 0 END) as total_entradas,
                    SUM(CASE WHEN tipo_movimiento = 'salida' THEN cantidad ELSE 0 END) as total_salidas,
                    SUM(CASE WHEN tipo_movimiento = 'venta' THEN cantidad ELSE 0 END) as total_ventas,
                    SUM(CASE WHEN tipo_movimiento = 'ajuste' THEN cantidad ELSE 0 END) as total_ajustes
                  FROM " . $this->table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener movimientos recientes (últimos 7 días)
    public function getRecientes($dias = 7) {
        $query = "SELECT 
                    h.*,
                    p.codigo as producto_codigo,
                    p.nombre as producto_nombre,
                    u.nombre as usuario_nombre
                  FROM " . $this->table . " h
                  LEFT JOIN productos p ON h.producto_id = p.id
                  LEFT JOIN usuarios u ON h.usuario_id = u.id
                  WHERE h.created_at >= DATE_SUB(NOW(), INTERVAL :dias DAY)
                  ORDER BY h.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dias', $dias, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Buscar en historial
    public function buscar($termino) {
        $query = "SELECT 
                    h.*,
                    p.codigo as producto_codigo,
                    p.nombre as producto_nombre,
                    u.nombre as usuario_nombre
                  FROM " . $this->table . " h
                  LEFT JOIN productos p ON h.producto_id = p.id
                  LEFT JOIN usuarios u ON h.usuario_id = u.id
                  WHERE p.codigo LIKE :termino 
                     OR p.nombre LIKE :termino
                     OR u.nombre LIKE :termino
                     OR h.observaciones LIKE :termino
                  ORDER BY h.created_at DESC
                  LIMIT 50";
        
        $stmt = $this->conn->prepare($query);
        $busqueda = "%{$termino}%";
        $stmt->bindParam(':termino', $busqueda);
        $stmt->execute();
        
        return $stmt;
    }
}
?>