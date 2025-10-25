<?php
class Producto {
    private $conn;
    private $table = "productos";

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $categoria;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE activo = 1 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function getTotalProductos() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getStockTotal() {
        $query = "SELECT SUM(stock) as total FROM " . $this->table . " WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getProductosBajoStock($limite = 10) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE activo = 1 AND stock <= :limite";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (codigo, nombre, descripcion, precio, stock, categoria) 
                  VALUES (:codigo, :nombre, :descripcion, :precio, :stock, :categoria)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":codigo", $this->codigo);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":categoria", $this->categoria);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? AND activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      precio = :precio, 
                      stock = :stock,
                      categoria = :categoria
                  WHERE id = :id AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "UPDATE " . $this->table . " SET activo = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function codigoExists($codigo, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT id FROM " . $this->table . " WHERE codigo = ? AND id != ? AND activo = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $codigo);
            $stmt->bindParam(2, $excludeId);
        } else {
            $query = "SELECT id FROM " . $this->table . " WHERE codigo = ? AND activo = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $codigo);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>