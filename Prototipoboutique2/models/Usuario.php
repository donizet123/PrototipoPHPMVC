<?php
class Usuario {
    private $conn;
    private $table = "usuarios";

    public $id;
    public $usuario;
    public $password;
    public $nombre;
    public $email;
    public $rol;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($usuario, $password) {
        $query = "SELECT id, usuario, password, nombre, email, rol 
                  FROM " . $this->table . " 
                  WHERE usuario = :usuario AND activo = 1 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar password
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        
        return false;
    }

    public function getById($id) {
        $query = "SELECT id, usuario, nombre, email, rol 
                  FROM " . $this->table . " 
                  WHERE id = :id AND activo = 1 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>