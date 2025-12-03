<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$db_name = "smartshop";

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "Database '$db_name' checked/created successfully.<br>";

    // Connect to the database
    $pdo->exec("USE `$db_name`");

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'client') DEFAULT 'client',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'users' checked/created successfully.<br>";

    // Insert default admin user if not exists
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $checkAdmin = $pdo->prepare("SELECT * FROM users WHERE email = 'admin@example.com'");
    $checkAdmin->execute();

    if ($checkAdmin->rowCount() == 0) {
        $insertAdmin = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES ('Admin', 'admin@example.com', :password, 'admin')");
        $insertAdmin->bindParam(':password', $adminPassword);
        $insertAdmin->execute();
        echo "Default admin user created (email: admin@example.com, password: admin123).<br>";
    } else {
        echo "Admin user already exists.<br>";
    }

    // Optional: Create other tables if they are missing (based on previous errors or assumptions)
    // Create categories table
    $sqlCategories = "CREATE TABLE IF NOT EXISTS categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL
    )";
    $pdo->exec($sqlCategories);
    echo "Table 'categorias' checked/created successfully.<br>";

    // Create products table
    $sqlProducts = "CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        precio DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL,
        imagen_url VARCHAR(255),
        categoria_id INT,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
    )";
    $pdo->exec($sqlProducts);
    echo "Table 'productos' checked/created successfully.<br>";


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
