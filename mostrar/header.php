<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/funciones/funciones_tienda.php';

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['usuario']) && $_SESSION['entro'] === true;

// Verifica si el usuario ha iniciado sesión
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;


// Determinar la página actual para resaltar el menú correspondiente
$current_page = basename($_SERVER['PHP_SELF']);
$body_class = '';

// Asignar clase específica según la página
if ($current_page == 'productos.php') {
    $body_class = 'productos-page';
} else if ($current_page == 'panaderia.php') {
    $body_class = 'panaderia-page';
} else if ($current_page == 'reposteria.php') {
    $body_class = 'reposteria-page';
} else if ($current_page == 'detallesArticulo.php') {
    $body_class = 'detalles-page';
} else if ($current_page == 'carrito.php') {
    $body_class = 'carrito-page';
} else if ($current_page == 'historial-compras.php') {
    $body_class = 'historial-page';
} else if (strpos($current_page, 'detalle-pedido.php') !== false) {
    $body_class = 'detalle-pedido-page';
}

// Añadir la clase al body
echo '<script>document.body.classList.add("' . $body_class . '");</script>';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elohim - Panadería y Repostería</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header-fixed">
        <div class="header-container">
            <!-- Logo -->
            <div class="logo-container">
                <a href="productos.php">
                    <img src="https://i.postimg.cc/nrGQ8SSX/logo.png" alt="Logo Elohim">
                </a>
            </div>
            
            <!-- Menú móvil -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Navegación principal -->
            <nav class="nav-container" id="navContainer">
                <ul class="nav-menu">
                    <li><a href="../index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">INICIO</a></li>
                    <li><a href="productos.php" class="<?= in_array($current_page, ['productos.php', 'panaderia.php', 'reposteria.php', 'detallesArticulo.php']) ? 'active' : '' ?>">PRODUCTOS</a></li>
                    <?php if ($isLoggedIn): ?>
                    <li><a href="historial-compras.php" class="<?= $current_page == 'historial-compras.php' ? 'active' : '' ?>">MIS PEDIDOS</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <!-- Iconos de carrito y usuario -->
            <div class="icons-container">
                <!-- Mostrar botón de panel solo si es admin (2) o vendedor (3) -->
                <?php if ($tipo_usuario == 2 || $tipo_usuario == 3): ?>
                    <?php
                        $panel_url = ($tipo_usuario == 2)
                            ? '../dash_board/index.php'
                            : '../dash_board/index_vendor.php';
                    ?>
                    <a href="<?= $panel_url ?>" class="panel-icon" title="Panel de control">
                        <i class="fas fa-home"></i>
                    </a>
                <?php endif; ?>
                <!-- Carrito simplificado -->
                <a href="carrito.php" class="cart-icon">
                    <i class="bi bi-cart-fill"></i>
                    <span class="cart-count"><?= iconoCarrito($con) ?></span>
                </a>
                <!-- Usuario -->
                <?php if ($isLoggedIn): ?>
                <div class="dropdown">
                    <a href="#" class="user-icon" id="userDropdown">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu" id="userDropdownMenu">
                        <a href="perfil.php" class="dropdown-item"><i class="bi bi-person"></i> Mi perfil</a>
                        <div class="dropdown-divider"></div>
                        <a href="../sesion/cerrar.php" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="../sesion/login.html" class="user-icon">
                    <i class="fas fa-user"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- Espacio para el header -->
    <div class="header-spacer"></div>
    
    <!-- Menú de categorías -->
    <?php if (in_array($current_page, ['productos.php', 'panaderia.php', 'reposteria.php'])): ?>
    <div class="categories-nav">
        <div class="categories-container">
            <a href="productos.php" class="category-item <?= $current_page == 'productos.php' ? 'active' : '' ?>">TODOS</a>
            <a href="panaderia.php" class="category-item <?= $current_page == 'panaderia.php' ? 'active' : '' ?>">PANADERÍA</a>
            <a href="reposteria.php" class="category-item <?= $current_page == 'reposteria.php' ? 'active' : '' ?>">REPOSTERÍA</a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Script para funcionalidad -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menú móvil
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navContainer = document.getElementById('navContainer');
        
        if (mobileMenuToggle && navContainer) {
            mobileMenuToggle.addEventListener('click', function() {
                navContainer.classList.toggle('active');
                this.classList.toggle('active');
            });
        }
        
        // Dropdown del usuario
        const userDropdown = document.getElementById('userDropdown');
        const userMenu = document.getElementById('userDropdownMenu');
        
        // Función para cerrar dropdown
        function closeDropdown() {
            if (userMenu) userMenu.classList.remove('show');
        }
        
        // Abrir/cerrar dropdown del usuario
        if (userDropdown && userMenu) {
            userDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                const isUserOpen = userMenu.classList.contains('show');
                closeDropdown();
                if (!isUserOpen) userMenu.classList.add('show');
            });
        }
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                closeDropdown();
            }
            
            // Cerrar menú móvil al hacer clic fuera
            if (!e.target.closest('#mobileMenuToggle') && !e.target.closest('#navContainer')) {
                if (navContainer) navContainer.classList.remove('active');
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
            }
        });
    });
    </script>
