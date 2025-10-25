<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/Session.php';

class CodigosController {
    private $db;
    private $producto;

    public function __construct() {
        Session::requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    // Vista principal de códigos
    public function index() {
        // Definir estructura de códigos
        $categorias_codigos = [
            [
                'rango' => 'VB001-VB099',
                'categoria' => 'Vestidos',
                'descripcion' => 'Todo tipo de vestidos: casuales, elegantes, de noche',
                'icono' => '👗',
                'color' => '#ffcdd2'
            ],
            [
                'rango' => 'VB100-VB199',
                'categoria' => 'Blusas',
                'descripcion' => 'Blusas, camisas y tops',
                'icono' => '👚',
                'color' => '#f8bbd0'
            ],
            [
                'rango' => 'VB200-VB299',
                'categoria' => 'Faldas',
                'descripcion' => 'Faldas cortas, largas y midi',
                'icono' => '🎽',
                'color' => '#e1bee7'
            ],
            [
                'rango' => 'VB300-VB399',
                'categoria' => 'Pantalones',
                'descripcion' => 'Pantalones casuales, formales y jeans',
                'icono' => '👖',
                'color' => '#c5cae9'
            ],
            [
                'rango' => 'VB400-VB499',
                'categoria' => 'Chaquetas',
                'descripcion' => 'Chaquetas, abrigos y sacos',
                'icono' => '🧥',
                'color' => '#bbdefb'
            ],
            [
                'rango' => 'VB500-VB599',
                'categoria' => 'Accesorios',
                'descripcion' => 'Cinturones, bufandas, joyería',
                'icono' => '💍',
                'color' => '#b2ebf2'
            ],
            [
                'rango' => 'VB600-VB699',
                'categoria' => 'Zapatos',
                'descripcion' => 'Tacones, zapatillas, sandalias',
                'icono' => '👠',
                'color' => '#b2dfdb'
            ],
            [
                'rango' => 'VB700-VB799',
                'categoria' => 'Carteras',
                'descripcion' => 'Bolsos de mano, mochilas, carteras',
                'icono' => '👜',
                'color' => '#c8e6c9'
            ]
        ];

        // Obtener estadísticas por categoría
        $query = "SELECT 
                    categoria,
                    COUNT(*) as total,
                    SUM(stock) as stock_total
                  FROM productos 
                  WHERE activo = 1
                  GROUP BY categoria";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $estadisticas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear array asociativo de estadísticas
        $stats_por_categoria = [];
        foreach ($estadisticas as $stat) {
            $stats_por_categoria[$stat['categoria']] = $stat;
        }

        // Obtener último código usado
        $query_ultimo = "SELECT codigo FROM productos WHERE activo = 1 ORDER BY id DESC LIMIT 1";
        $stmt_ultimo = $this->db->prepare($query_ultimo);
        $stmt_ultimo->execute();
        $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        $ultimo_codigo = $ultimo ? $ultimo['codigo'] : 'Ninguno';

        require_once __DIR__ . '/../views/codigos/index.php';
    }

    // Generar siguiente código
    public function generar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = trim($_POST['categoria']);
            
            // Mapeo de categorías a rangos
            $rangos = [
                'Vestidos' => ['min' => 1, 'max' => 99],
                'Blusas' => ['min' => 100, 'max' => 199],
                'Faldas' => ['min' => 200, 'max' => 299],
                'Pantalones' => ['min' => 300, 'max' => 399],
                'Chaquetas' => ['min' => 400, 'max' => 499],
                'Accesorios' => ['min' => 500, 'max' => 599],
                'Zapatos' => ['min' => 600, 'max' => 699],
                'Carteras' => ['min' => 700, 'max' => 799]
            ];

            if (!isset($rangos[$categoria])) {
                echo json_encode(['error' => 'Categoría inválida']);
                exit;
            }

            $rango = $rangos[$categoria];
            
            // Buscar último código en el rango
            $query = "SELECT codigo FROM productos 
                      WHERE codigo REGEXP '^VB[0-9]+$'
                      AND CAST(SUBSTRING(codigo, 3) AS UNSIGNED) BETWEEN :min AND :max
                      ORDER BY CAST(SUBSTRING(codigo, 3) AS UNSIGNED) DESC
                      LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':min', $rango['min']);
            $stmt->bindParam(':max', $rango['max']);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                $ultimo_numero = intval(substr($resultado['codigo'], 2));
                $nuevo_numero = $ultimo_numero + 1;
                
                if ($nuevo_numero > $rango['max']) {
                    echo json_encode(['error' => 'Rango completo para esta categoría']);
                    exit;
                }
            } else {
                $nuevo_numero = $rango['min'];
            }
            
            $nuevo_codigo = 'VB' . str_pad($nuevo_numero, 3, '0', STR_PAD_LEFT);
            
            echo json_encode([
                'success' => true,
                'codigo' => $nuevo_codigo,
                'categoria' => $categoria
            ]);
            exit;
        }
        
        require_once __DIR__ . '/../views/codigos/generar.php';
    }

    // Verificar disponibilidad de código
    public function verificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = trim($_POST['codigo']);
            
            $query = "SELECT id FROM productos WHERE codigo = :codigo AND activo = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            
            $existe = $stmt->rowCount() > 0;
            
            echo json_encode([
                'existe' => $existe,
                'disponible' => !$existe,
                'codigo' => $codigo
            ]);
            exit;
        }
    }
}
?>