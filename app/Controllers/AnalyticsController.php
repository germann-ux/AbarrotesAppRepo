<?php
require_once 'app/Config/Database.php';
require_once 'app/Models/Product.php';

class AnalyticsController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function index() {
        $totalProducts = $this->product->countAll();
        
        $recentProductsStmt = $this->product->getRecent(5);
        $recentProducts = $recentProductsStmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'app/Views/analytics.php';
    }
}
?>
