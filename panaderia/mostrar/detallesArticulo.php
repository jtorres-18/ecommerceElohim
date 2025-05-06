<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'config/config.php';
require_once 'funciones/funciones_tienda.php';

// Función para obtener productos relacionados
if (!function_exists('obtener_productos_relacionados')) {
    function obtener_productos_relacionados($con, $categoria, $idProd, $limit) {
        // Verificar si la categoría está definida
        if (!isset($categoria) || $categoria === '') {
            return false;
        }

        $query = "SELECT p.*, f.foto1 
                 FROM productos p
                 JOIN fotoproducts f ON p.id = f.products_id
                 WHERE p.categoria = ? AND p.id != ? AND p.estado = 1
                 LIMIT ?";
        
        $stmt = $con->prepare($query);
        
        if ($stmt === false) {
            error_log("Error en prepare(): " . $con->error);
            return false;
        }
        
        $categoria = (int)$categoria;
        $idProd = (int)$idProd;
        $limit = (int)$limit;
        
        if (!$stmt->bind_param('iii', $categoria, $idProd, $limit)) {
            error_log("Error en bind_param(): " . $stmt->error);
            return false;
        }
        
        if (!$stmt->execute()) {
            error_log("Error en execute(): " . $stmt->error);
            return false;
        }
        
        return $stmt->get_result();
    }
}

// Generar un token único para el cliente si no existe
if (!isset($_SESSION['tokenStoragel'])) {
    $_SESSION['tokenStoragel'] = md5(uniqid(mt_rand(), true));
}

// Verificar si se ha proporcionado un ID de producto
if (!isset($_GET['idProd']) || empty($_GET['idProd'])) {
    header('Location: productos.php');
    exit;
}

$idProd = intval($_GET['idProd']);

// Obtener los detalles del producto
$resultadoProducto = detalles_producto_seleccionado($con, $idProd);

if (!$resultadoProducto || mysqli_num_rows($resultadoProducto) == 0) {
    header('Location: productos.php');
    exit;
}

$dataProducto = mysqli_fetch_array($resultadoProducto);

// Manejo seguro de la categoría
$categoriaProducto = isset($dataProducto['categoria']) ? $dataProducto['categoria'] : null;

// Incluir el header
include 'header.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo htmlspecialchars($dataProducto['nameProd'], ENT_QUOTES, 'UTF-8'); ?> - Elohim</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/responsive.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/producto-detalle.css">
    <!-- Estilos adicionales del primer código -->
    <link rel="stylesheet" type="text/css" href="assets/styles/single_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/single_responsive.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos para notificaciones */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }
        .toast-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        .toast-notification.error {
            background-color: #dc3545;
        }
    </style>
</head>

<body class="product-detail-page">
    <!-- Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div>
            <span>cargando...</span>
        </div>
    </div>

    <main class="main-content">
        <div class="container mt-5">
            <div class="product-detail-container">
                <div class="row">
                    <!-- Galería de imágenes -->
                    <div class="col-lg-6">
                        <div class="product-gallery">
                            <div class="main-image">
                                <img src="../dash_board/img/<?php echo htmlspecialchars($dataProducto["foto1"], ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($dataProducto['nameProd'], ENT_QUOTES, 'UTF-8'); ?>" 
                                     class="img-fluid">
                            </div>
                            <?php if (!empty($dataProducto["foto2"]) || !empty($dataProducto["foto3"])): ?>
                            <div class="thumbnail-images">
                                <div class="thumbnail active">
                                    <img src="../dash_board/img/<?php echo htmlspecialchars($dataProducto["foto1"], ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="Miniatura 1">
                                </div>
                                <?php if (!empty($dataProducto["foto2"])): ?>
                                <div class="thumbnail">
                                    <img src="../dash_board/img/<?php echo htmlspecialchars($dataProducto["foto2"], ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="Miniatura 2">
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($dataProducto["foto3"])): ?>
                                <div class="thumbnail">
                                    <img src="../dash_board/img/<?php echo htmlspecialchars($dataProducto["foto3"], ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="Miniatura 3">
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Información del producto -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <h1 class="product-title"><?php echo htmlspecialchars($dataProducto['nameProd'], ENT_QUOTES, 'UTF-8'); ?></h1>
                            
                            <?php if (!empty($dataProducto['codigo'])): ?>
                            <div class="product-sku">
                                SKU: <?php echo htmlspecialchars($dataProducto['codigo'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="product-price">
                                $<?php echo number_format($dataProducto['precio'], 0, '', '.'); ?>
                            </div>
                            
                            <?php if (!empty($categoriaProducto)): ?>
                            <div class="product-category">
                                <span>Categoría:</span> 
                                <?php 
                                if ($categoriaProducto == 1) {
                                    $nombreCategoria = 'Panadería';
                                } elseif ($categoriaProducto == 2) {
                                    $nombreCategoria = 'Repostería';
                                } else {
                                    $nombreCategoria = 'General';
                                }
                                echo htmlspecialchars($nombreCategoria, ENT_QUOTES, 'UTF-8'); 
                                ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="product-quantity">
                                <label for="quantity">Cantidad:</label>
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="99">
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            
                            <div class="product-actions">
                                <button type="button" id="btn-agregar-carrito" class="btn btn-primary"
                                    data-id="<?php echo $dataProducto['prodId']; ?>" 
                                    data-precio="<?php echo $dataProducto['precio']; ?>" 
                                    data-token="<?php echo $_SESSION['tokenStoragel']; ?>">
                                    <i class="bi bi-cart-plus"></i> Agregar al carrito
                                </button>
                                <button type="button" id="btn-comprar-ahora" class="btn btn-success">
                                    <i class="bi bi-bag-check"></i> Comprar ahora
                                </button>
                                <a href="productos.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Volver a Productos
                                </a>
                            </div>
                            
                            <div class="product-description">
                                <h3>Descripción del producto</h3>
                                <div class="description-content">
                                    <?php echo nl2br(htmlspecialchars($dataProducto['description_Prod'], ENT_QUOTES, 'UTF-8')); ?>
                                </div>
                            </div>
                            
                            <div class="product-meta">
                                <div class="delivery-info">
                                    <i class="bi bi-truck"></i> Envío a domicilio disponible
                                </div>
                                <div class="payment-info">
                                    <i class="bi bi-credit-card"></i> Múltiples métodos de pago
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Productos relacionados - Solo si tiene categoría -->
            <?php if (!empty($categoriaProducto)): ?>
                <?php
                $productosRelacionados = obtener_productos_relacionados($con, $categoriaProducto, $idProd, 4);
                if ($productosRelacionados !== false && mysqli_num_rows($productosRelacionados) > 0):
                ?>
                <div class="related-products mt-5">
                    <h2 class="section-title">Productos relacionados</h2>
                    <div class="row">
                        <?php while ($productoRel = mysqli_fetch_array($productosRelacionados)): ?>
                        <div class="col-md-3 col-6">
                            <div class="product-card">
                                <a href="detallesArticulo.php?idProd=<?php echo $productoRel['id']; ?>" class="product-link">
                                    <div class="product-image">
                                        <img src="../dash_board/img/<?php echo htmlspecialchars($productoRel["foto1"], ENT_QUOTES, 'UTF-8'); ?>" 
                                             alt="<?php echo htmlspecialchars($productoRel['nameProd'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title"><?php echo htmlspecialchars($productoRel['nameProd'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                        <div class="product-price">$<?php echo number_format($productoRel['precio'], 0, '', '.'); ?></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include('includes/footer.html'); ?>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/styles/bootstrap4/popper.js"></script>
    <script src="assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="assets/js/loader.js"></script>
    <script>
        $(document).ready(function() {
            // Ocultar loader cuando la página esté cargada
            setTimeout(function() {
                $('.page-loading').removeClass('active');
            }, 500);

            // Galería de imágenes
            $('.thumbnail').on('click', function() {
                const imgSrc = $(this).find('img').attr('src');
                $('.main-image img').attr('src', imgSrc);
                $('.thumbnail').removeClass('active');
                $(this).addClass('active');
            });
            
            // Controles de cantidad (mejorados del primer código)
            $('.plus').click(function() {
                let quantity = parseInt($('#quantity').val());
                if (quantity < 99) {
                    $('#quantity').val(quantity + 1);
                }
            });
            
            $('.minus').click(function() {
                let quantity = parseInt($('#quantity').val());
                if (quantity > 1) {
                    $('#quantity').val(quantity - 1);
                }
            });
            
            // Agregar al carrito (combinación de ambos códigos)
            $('#btn-agregar-carrito').on('click', function() {
                const idProduct = $(this).data('id');
                const precio = $(this).data('precio');
                const tokenCliente = $(this).data('token');
                const cantidad = parseInt($('#quantity').val());
                
                console.log("Agregando producto:", idProduct, "Precio:", precio, "Token:", tokenCliente, "Cantidad:", cantidad);
                
                // Validación básica
                if (cantidad < 1 || cantidad > 99) {
                    mostrarNotificacion('Cantidad no válida', 'error');
                    return;
                }

                $.ajax({
                    url: 'funciones/funciones_carrito.php',
                    type: 'POST',
                    data: {
                        accion: 'addCar',
                        idProduct: idProduct,
                        precio: precio,
                        tokenCliente: tokenCliente,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        console.log("Respuesta del servidor:", response);
                        if (!isNaN(response)) {
                            $('.cart-count').text(response);
                            mostrarNotificacion('Producto agregado al carrito', 'success');
                        } else {
                            mostrarNotificacion('Error inesperado', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al agregar al carrito:', error);
                        console.error('Respuesta del servidor:', xhr.responseText);
                        mostrarNotificacion('Error al agregar al carrito', 'error');
                    }
                });
            });
            
            // Comprar ahora (nueva funcionalidad)
            $('#btn-comprar-ahora').on('click', function() {
                $('#btn-agregar-carrito').trigger('click');
                setTimeout(function() {
                    window.location.href = 'carrito.php';
                }, 1000);
            });

            // Función para mostrar notificaciones (nueva funcionalidad)
            function mostrarNotificacion(mensaje, tipo) {
                const toast = $(`<div class="toast-notification ${tipo}">${mensaje}</div>`);
                $('body').append(toast);
                
                setTimeout(function() {
                    toast.addClass('show');
                    setTimeout(function() {
                        toast.removeClass('show');
                        setTimeout(function() {
                            toast.remove();
                        }, 300);
                    }, 2000);
                }, 100);
            }
        });
    </script>
<!-- Contenedor para el chatbot -->
<div id="chatbot-container"></div>

<script>
// Cargar el chatbot dinámicamente con jQuery
$(document).ready(function() {
    $.get('/panaderia/chatbot/chatbot.html')
        .done(function(data) {
            $('body').append(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error al cargar el chatbot:', textStatus, errorThrown);
            // Mensaje opcional para el usuario
            alert('El servicio de chat no está disponible temporalmente');
        });
});
</script>

</body>

</html>