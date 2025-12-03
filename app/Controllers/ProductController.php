<?php
require_once 'app/Config/Database.php';
require_once 'app/Models/Product.php';
require_once 'app/Models/Category.php';

class ProductController {
    private $db;
    private $product;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
        $this->category = new Category($this->db);
    }

    public function index() {
        $stmt = $this->product->getAll();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'app/Views/products.php';
    }

    // API methods
    public function apiGetAll() {
        $stmt = $this->product->getAll();
        $num = $stmt->rowCount();
        $products_arr = array();

        if($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $product_item = array(
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "precio" => $precio,
                    "stock" => $stock,
                    "imagen_url" => $imagen_url,
                    "categoria_id" => $categoria_id,
                    "categoria_nombre" => $categoria_nombre
                );
                array_push($products_arr, $product_item);
            }
            echo json_encode($products_arr);
        } else {
            echo json_encode(array());
        }
    }

    public function apiGetCategories() {
        $stmt = $this->category->getAll();
        $categories_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($categories_arr, $row);
        }
        echo json_encode($categories_arr);
    }

    public function apiCreate() {
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->nombre) && !empty($data->categoria_id)) {
            $this->product->nombre = $data->nombre;
            $this->product->descripcion = $data->descripcion;
            $this->product->precio = $data->precio;
            $this->product->stock = $data->stock;
            $this->product->imagen_url = $data->imagen_url;
            $this->product->categoria_id = $data->categoria_id;

            if($this->product->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Producto creado."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "No se pudo crear el producto."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Datos incompletos."));
        }
    }

    public function apiUpdate() {
        $data = json_decode(file_get_contents("php://input"));
        
        $this->product->id = $data->id;
        $this->product->nombre = $data->nombre;
        $this->product->descripcion = $data->descripcion;
        $this->product->precio = $data->precio;
        $this->product->stock = $data->stock;
        $this->product->imagen_url = $data->imagen_url;
        $this->product->categoria_id = $data->categoria_id;

        if($this->product->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Producto actualizado."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo actualizar el producto."));
        }
    }

    public function apiDelete() {
        $data = json_decode(file_get_contents("php://input"));
        $this->product->id = $data->id;

        if($this->product->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Producto eliminado."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo eliminar el producto."));
        }
    }
}
?>
