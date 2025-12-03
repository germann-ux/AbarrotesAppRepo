<?php
session_start();

require_once 'app/Controllers/DashboardController.php';
require_once 'app/Controllers/ProductController.php';
require_once 'app/Controllers/AnalyticsController.php';
require_once 'app/Controllers/AuthController.php';
require_once 'app/Controllers/ClientController.php';
require_once 'app/Controllers/OrderController.php';

// Handle Client Actions (no auth required for shopping)
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    // Client routes that don't require authentication
    if (in_array($action, ['client', 'add_to_cart', 'cart', 'update_cart', 'remove_from_cart', 'checkout', 'process_order', 'order_confirmation'])) {
        $clientController = new ClientController();
        
        switch($action) {
            case 'client':
                $clientController->index();
                break;
            case 'add_to_cart':
                $clientController->addToCart();
                break;
            case 'cart':
                $clientController->viewCart();
                break;
            case 'update_cart':
                $clientController->updateCart();
                break;
            case 'remove_from_cart':
                $clientController->removeFromCart();
                break;
            case 'checkout':
                $clientController->checkout();
                break;
            case 'process_order':
                $clientController->processOrder();
                break;
            case 'order_confirmation':
                $clientController->orderConfirmation();
                break;
        }
        exit;
    }
}

// Handle Auth Actions
if (isset($_GET['action']) && in_array($_GET['action'], ['login', 'register', 'logout'])) {
    $authController = new AuthController();
    if ($_GET['action'] == 'login') {
        $authController->login();
    } elseif ($_GET['action'] == 'register') {
        $authController->register();
    } elseif ($_GET['action'] == 'logout') {
        $authController->logout();
    }
    exit;
}

// Handle Views that don't require auth (login/register)
$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

if ($view == 'login') {
    $authController = new AuthController();
    $authController->login();
    exit;
}
if ($view == 'register') {
    $authController = new AuthController();
    $authController->register();
    exit;
}

// Middleware Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

// Handle API Actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    $productController = new ProductController();
    $orderController = new OrderController();
    
    switch($action) {
        case 'api_get_products':
            $productController->apiGetAll();
            break;
        case 'api_get_categories':
            $productController->apiGetCategories();
            break;
        case 'api_create_product':
            $productController->apiCreate();
            break;
        case 'api_update_product':
            $productController->apiUpdate();
            break;
        case 'api_delete_product':
            $productController->apiDelete();
            break;
        case 'api_get_orders':
            $orderController->apiGetAll();
            break;
        case 'api_get_order':
            $orderController->apiGetById();
            break;
        case 'api_update_order_status':
            $orderController->apiUpdateStatus();
            break;
        default:
            http_response_code(404);
            echo json_encode(["message" => "Action not found"]);
            break;
    }
    exit;
}

// Role Check for Admin Views
if (in_array($view, ['dashboard', 'productos', 'analytics', 'ordenes']) && $_SESSION['role'] !== 'admin') {
    // Redirect non-admins to their dashboard
    header("Location: index.php?view=client_dashboard");
    exit;
}

require_once 'app/Views/layouts/header.php';
require_once 'app/Views/layouts/sidebar.php';
require_once 'app/Views/layouts/navbar.php';

switch($view) {
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'productos':
        $controller = new ProductController();
        $controller->index();
        break;
    case 'analytics':
        $controller = new AnalyticsController();
        $controller->index();
        break;
    case 'ordenes':
        $controller = new OrderController();
        $controller->index();
        break;
    case 'client_dashboard':
        $controller = new ClientController();
        $controller->index();
        break;
    default:
        // Default fallback based on role
        if ($_SESSION['role'] === 'admin') {
            $controller = new DashboardController();
            $controller->index();
        } else {
            $controller = new ClientController();
            $controller->index();
        }
        break;
}

require_once 'app/Views/layouts/footer.php';
?>