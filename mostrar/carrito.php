<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../sesion/login.html');
    exit;
}
require_once 'config/config.php';
require_once 'funciones/funciones_tienda.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Carrito - Elohim</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/single_styles.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div>
            <span>cargando...</span>
        </div>
    </div>

    <?php
    include('modalEliminarProduct.php');
    include('header.php');
    ?>

    <main class="main-content">
        <div class="container mt-4">
            <?php
            $miCarrito = mi_carrito_de_compra($con);
            if ($miCarrito && mysqli_num_rows($miCarrito) > 0) { ?>
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-4">Resumen de mi Pedido</h2>
                        <div class="table-responsive">
                            <table class="table table-hover cart-table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="100"></th>
                                        <th scope="col">Producto</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col" class="text-right">Precio</th>
                                        <th class="text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($dataMiProd = mysqli_fetch_array($miCarrito)) { ?>
                                        <tr id="resp<?php echo $dataMiProd['tempId']; ?>">
                                            <td>
                                                <img src="../dash_board/img/<?php echo htmlspecialchars($dataMiProd["foto1"], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto_Producto" class="product-thumbnail">
                                            </td>
                                            <td class="product-name"><?php echo htmlspecialchars($dataMiProd["nameProd"], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <div class="quantity-control">
                                                    <button type="button" class="btn-quantity btn-decrease" 
                                                            data-id="<?php echo $dataMiProd['tempId']; ?>" 
                                                            data-precio="<?php echo $dataMiProd['precio']; ?>" 
                                                            data-token="<?php echo $_SESSION['tokenStoragel']; ?>">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <span id="display<?php echo $dataMiProd['tempId']; ?>" class="quantity-display">
                                                        <?php echo $dataMiProd["cantidad"]; ?>
                                                    </span>
                                                    <button type="button" class="btn-quantity btn-increase" 
                                                            data-id="<?php echo $dataMiProd['tempId']; ?>" 
                                                            data-precio="<?php echo $dataMiProd['precio']; ?>" 
                                                            data-token="<?php echo $_SESSION['tokenStoragel']; ?>">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-right price-column">
                                                $<?php echo number_format($dataMiProd['precio'], 0, '', '.'); ?>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-danger btn-delete" 
                                                        data-id="<?php echo $dataMiProd['tempId']; ?>" 
                                                        data-token="<?php echo $_SESSION['tokenStoragel']; ?>">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total a Pagar:</strong></td>
                                        <td colspan="2" class="total-amount">
                                            <span id="totalPuntos">
                                                $<?php echo totalAcumuladoDeuda($con); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="row cart-actions">
                            <div class="col-md-6 mb-3">
                                <a href="productos.php" class="btn btn-outline-primary btn-block">
                                    <i class="bi bi-cart-plus"></i>
                                    Continuar Comprando
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                    Finalizar Pedido
                                    <i class="bi bi-arrow-right-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Finalizar Pedido -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="checkoutModalLabel">Detalles de la compra</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="checkoutForm">
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección de entrega:</label>
                                        <input type="text" class="form-control" id="direccion" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono de contacto:</label>
                                        <input type="tel" class="form-control" id="telefono" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="metodo_pago" class="form-label">Método de pago:</label>
                                        <select class="form-select" id="metodo_pago" required>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="transferencia">Transferencia bancaria</option>
                                            <option value="tarjeta">Tarjeta de crédito/débito</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" id="btnFinalizarCompra" class="btn btn-success">Confirmar Pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-12 text-center empty-cart">
                        <i class="bi bi-cart-x"></i>
                        <h3>Tu carrito está vacío</h3>
                        <p>No tienes productos en tu carrito de compras.</p>
                        <a href="productos.php" class="btn btn-primary mt-3">
                            <i class="bi bi-shop"></i> Ir a comprar
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <?php include('includes/footer.html'); ?>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/styles/bootstrap4/popper.js"></script>
    <script src="assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/loader.js"></script>
    <script>
        $(document).ready(function() {
            // Aumentar cantidad
            $('.btn-increase').click(function() {
                const id = $(this).data('id');
                const precio = $(this).data('precio');
                const token = $(this).data('token');
                const displayElement = $('#display' + id);
                const currentQuantity = parseInt(displayElement.text());
                const newQuantity = currentQuantity + 1;
                
                $.ajax({
                    url: 'funciones/funciones_carrito.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        aumentarCantidad: newQuantity,
                        idProd: id,
                        precio: precio,
                        tokenCliente: token
                    },
                    success: function(response) {
                        if (response.estado === 'OK') {
                            // Actualizar la cantidad mostrada
                            displayElement.text(newQuantity);
                            
                            // Actualizar el total
                            $('#totalPuntos').text('$' + formatNumber(response.totalPagar));
                            
                            // Actualizar el contador del carrito
                            updateCartCount();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al aumentar cantidad:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo actualizar la cantidad'
                        });
                    }
                });
            });
            
            // Disminuir cantidad
            $('.btn-decrease').click(function() {
                const id = $(this).data('id');
                const precio = $(this).data('precio');
                const token = $(this).data('token');
                const displayElement = $('#display' + id);
                const currentQuantity = parseInt(displayElement.text());
                
                if (currentQuantity > 1) {
                    const newQuantity = currentQuantity - 1;
                    
                    $.ajax({
                        url: 'funciones/funciones_carrito.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            accion: 'disminuirCantidad',
                            idProd: id,
                            precio: precio,
                            tokenCliente: token,
                            cantidad_Disminuida: newQuantity
                        },
                        success: function(response) {
                            if (response.estado === 'OK') {
                                // Actualizar la cantidad mostrada
                                displayElement.text(newQuantity);
                                
                                // Actualizar el total
                                $('#totalPuntos').text('$' + formatNumber(response.totalPagar));
                                
                                // Actualizar el contador del carrito
                                updateCartCount();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al disminuir cantidad:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo actualizar la cantidad'
                            });
                        }
                    });
                } else {
                    // Si la cantidad es 1, preguntar si desea eliminar el producto
                    Swal.fire({
                        title: '¿Eliminar producto?',
                        text: '¿Deseas eliminar este producto del carrito?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'No, mantener'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteProduct(id, token);
                        }
                    });
                }
            });
            
            // Eliminar producto
            $('.btn-delete').click(function() {
                const id = $(this).data('id');
                const token = $(this).data('token');
                
                Swal.fire({
                    title: '¿Eliminar producto?',
                    text: '¿Estás seguro de que deseas eliminar este producto del carrito?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteProduct(id, token);
                    }
                });
            });
            
            // Función para eliminar producto
            function deleteProduct(id, token) {
                $.ajax({
                    url: 'funciones/funciones_carrito.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'borrarproductoModal',
                        idProduct: id,
                        tokenCliente: token
                    },
                    success: function(response) {
                        if (response.estado === 'OK') {
                            // Eliminar la fila de la tabla
                            $('#resp' + id).fadeOut(300, function() {
                                $(this).remove();
                                
                                // Actualizar el total
                                $('#totalPuntos').text('$' + formatNumber(response.totalPagar));
                                
                                // Actualizar el contador del carrito
                                updateCartCount();
                                
                                // Si no quedan productos, recargar la página
                                if (response.totalProductos == 0) {
                                    location.reload();
                                }
                            });
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: 'Producto eliminado del carrito',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar producto:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar el producto'
                        });
                    }
                });
            }
            
            
            
            // Función para actualizar el contador del carrito
            function updateCartCount() {
                $.ajax({
                    url: 'funciones/funciones_carrito.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'obtenerTotalProductos',
                        tokenCliente: '<?php echo isset($_SESSION["tokenStoragel"]) ? $_SESSION["tokenStoragel"] : ""; ?>'
                    },
                    success: function(response) {
                        $('.cart-count').text(response.total);
                    }
                });
            }
            
            // Función para formatear números
            function formatNumber(number) {
                return new Intl.NumberFormat('es-CO').format(number);
            }
        });
    </script>
    <script src="funciones/scrips_pedido.js"></script>
    </body>
</html>
