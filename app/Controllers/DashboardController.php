<?php
require_once 'app/Config/Database.php';
require_once 'app/Models/Product.php';
require_once 'app/Models/Category.php';

class DashboardController {
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
        $totalProducts = $this->product->countAll();
        $totalCategories = $this->category->countAll();
        $lowStock = $this->product->countLowStock(10); //hilo en 10 segudos

        $stockByCategoryStmt = $this->product->getStockByCategory();
        $stockLabels = [];
        $stockData = [];
        while($row = $stockByCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
            $stockLabels[] = $row['nombre'];
            $stockData[] = $row['total_stock'];
        }

        $countByCategoryStmt = $this->product->getCountByCategory();
        $countLabels = [];
        $countData = [];
        while($row = $countByCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
            $countLabels[] = $row['nombre'];
            $countData[] = $row['total_products'];
        }

        require_once 'app/Views/dashboard.php';
    }
}
?>
