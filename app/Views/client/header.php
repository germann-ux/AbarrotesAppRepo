<?php $searchQuery = $searchQuery ?? ''; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Tienda Online'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Header Fijo */
        .header-top {
            background: #fff159;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 900;
            color: #3483fa;
            text-decoration: none;
        }
        
        .logo:hover {
            color: #2968c8;
        }
        
        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-bar input {
            border-radius: 2px;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .cart-button {
            background: transparent;
            border: none;
            color: #333;
            font-size: 1.5rem;
            position: relative;
            padding: 10px 15px;
            cursor: pointer;
            transition: color 0.2s;
            text-decoration: none;
        }
        
        .cart-button:hover {
            color: #3483fa;
        }
        
        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #3483fa;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        /* Breadcrumb de Pasos */
        .checkout-steps {
            background: white;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        
        .steps-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }
        
        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #999;
            font-weight: 600;
        }
        
        .step.active {
            color: #3483fa;
        }
        
        .step.completed {
            color: #00a650;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .step.active .step-icon {
            background: #3483fa;
            color: white;
        }
        
        .step.completed .step-icon {
            background: #00a650;
            color: white;
        }
        
        .step-arrow {
            color: #ccc;
            font-size: 1.5rem;
        }
        
        /* Alert Messages */
        .alert-floating {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    
    <!-- Header estilo Mercado Libre -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a href="<?php echo url_for('index.php?action=client'); ?>" class="logo">
                        <i class="bi bi-cart-fill"></i> MiTienda
                    </a>
                </div>
                <div class="col-md-8">
                    <div class="search-bar">
                        <form class="input-group" method="GET" action="<?php echo url_for('index.php'); ?>">
                            <input type="hidden" name="action" value="client">
                            <input
                                type="text"
                                class="form-control"
                                name="q"
                                placeholder="Buscar productos..."
                                value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>"
                                aria-label="Buscar productos"
                            >
                            <button class="btn btn-light" type="submit" aria-label="Buscar">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <a href="<?php echo url_for('index.php?action=cart'); ?>" class="cart-button">
                        <i class="bi bi-cart3"></i>
                        <?php 
                        if (session_status() === PHP_SESSION_NONE) session_start();
                        require_once __DIR__ . '/../../Models/Cart.php';
                        $cartCount = Cart::getItemCount();
                        if ($cartCount > 0): 
                        ?>
                        <span class="cart-badge"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mensajes Flotantes -->
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show alert-floating" role="alert">
        <i class="bi bi-check-circle-fill"></i> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show alert-floating" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <!-- Pasos del Checkout -->
    <?php if (isset($showSteps) && $showSteps): ?>
    <div class="checkout-steps">
        <div class="container">
            <div class="steps-container">
                <div class="step <?php echo ($currentStep ?? 1) >= 1 ? 'completed' : ''; ?> <?php echo ($currentStep ?? 1) == 1 ? 'active' : ''; ?>">
                    <div class="step-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <span>Carrito</span>
                </div>
                
                <div class="step-arrow">›</div>
                
                <div class="step <?php echo ($currentStep ?? 1) >= 2 ? 'completed' : ''; ?> <?php echo ($currentStep ?? 1) == 2 ? 'active' : ''; ?>">
                    <div class="step-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <span>Datos</span>
                </div>
                
                <div class="step-arrow">›</div>
                
                <div class="step <?php echo ($currentStep ?? 1) >= 3 ? 'completed' : ''; ?> <?php echo ($currentStep ?? 1) == 3 ? 'active' : ''; ?>">
                    <div class="step-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <span>Confirmación</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
