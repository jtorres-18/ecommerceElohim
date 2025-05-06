<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el archivo de configuración si no está incluido
if (!function_exists('conectar')) {
    require_once __DIR__ . '/config/config.php';
}

// Definir la función iconoCarrito si no existe
if (!function_exists('iconoCarrito')) {
    function iconoCarrito($con) {
        if (!isset($_SESSION['tokenStoragel']) || empty($_SESSION['tokenStoragel'])) {
            return 0;
        }
        
        $token = $_SESSION['tokenStoragel'];
        $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd FROM pedidostemporales WHERE tokenCliente = ?";
        
        $stmt = mysqli_prepare($con, $sqlTotalProduct);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $token);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($result && $row = mysqli_fetch_assoc($result)) {
                return $row['totalProd'] ? $row['totalProd'] : 0;
            }
        }
        
        return 0;
    }
}

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
}

// Añadir la clase al body
echo '<script>document.body.classList.add("' . $body_class . '");</script>';
?>

<!-- Header fijo -->
<header class="header-fixed">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo-container">
            <a href="productos.php">
                <img src="https://i.postimg.cc/nrGQ8SSX/logo.png" alt="Logo Elohim">
            </a>
        </div>
        
        <!-- Botón de menú móvil -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Menú de navegación -->
        <nav class="nav-container" id="nav-container">
            <ul class="nav-menu">
                <li><a href="../index.html" class="<?= $current_page == 'index.html' ? 'active' : '' ?>">INICIO</a></li>
                <li><a href="productos.php" class="<?= ($current_page == 'productos.php' || $current_page == 'panaderia.php' || $current_page == 'reposteria.php' || $current_page == 'detallesArticulo.php') ? 'active' : '' ?>">PRODUCTOS</a></li>
                <li><a href="../contacto.html" class="<?= $current_page == 'contacto.html' ? 'active' : '' ?>">CONTACTO</a></li>
            </ul>
        </nav>
        
        <!-- Carrito -->
        <div class="cart-container">
            <a href="carrito.php" class="cart-icon">
                <i class="bi bi-cart-fill"></i>
                <span class="cart-count"><?php echo iconoCarrito($con); ?></span>
            </a>
        </div>
    </div>
</header>

<!-- Espacio para compensar el header fijo -->
<div class="header-spacer"></div>

<?php if ($current_page == 'productos.php' || $current_page == 'panaderia.php' || $current_page == 'reposteria.php'): ?>
<!-- Menú de categorías -->
<div class="categories-nav">
    <div class="categories-container">
        <a href="productos.php" class="category-item <?= $current_page == 'productos.php' ? 'active' : '' ?>">TODOS</a>
        <a href="panaderia.php" class="category-item <?= $current_page == 'panaderia.php' ? 'active' : '' ?>">PANADERÍA</a>
        <a href="reposteria.php" class="category-item <?= $current_page == 'reposteria.php' ? 'active' : '' ?>">REPOSTERÍA</a>
    </div>
</div>
<?php endif; ?>

<!-- Script para el menú móvil -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navContainer = document.getElementById('nav-container');
    
    if (mobileMenuToggle && navContainer) {
        mobileMenuToggle.addEventListener('click', function() {
            navContainer.classList.toggle('active');
        });
    }
});
</script>
