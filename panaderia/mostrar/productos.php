<?php
session_start();
include('config/config.php');
include('funciones/funciones_tienda.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Panadería Elohim</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <link rel="stylesheet" href="assets/styles/header.css">
</head>

<body>
    <!-- Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div>
            <span>cargando...</span>
        </div>
    </div>

    <?php include('header.php'); ?>  

    <main class="main-content">
        <div class="container mt-4">
            <?php
            // Obtener datos de productos y controlar errores
            $resultadoProductos = getProductData($con);
            if (!$resultadoProductos) {
                die("Error en getProductData: " . mysqli_error($con));
            }
            ?>

            <div class="row align-items-center">
                <?php if (mysqli_num_rows($resultadoProductos) > 0): ?>
                    <?php while ($dataProduct = mysqli_fetch_array($resultadoProductos)): ?>
                        <div class="col-6 col-md-3 mt-4 text-center Products">
                            <div class="card" style="max-height:450px; min-height:450px; margin-bottom:20px;">
                                <div>
                                    <img
                                        class="card-img-top text-center mt-4"
                                        src="../dash_board/img/<?php echo htmlspecialchars($dataProduct["foto1"], ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="<?php echo htmlspecialchars($dataProduct['nameProd'], ENT_QUOTES, 'UTF-8'); ?>"
                                        style="max-width:200px;"
                                    >
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title card_title">
                                        <?php echo htmlspecialchars($dataProduct['nameProd'], ENT_QUOTES, 'UTF-8'); ?>
                                    </h5>
                                    <?php
                                    $isEven = $dataProduct["prodId"] % 2 === 0;
                                    for ($i = 1; $i <= 5; $i++) {
                                        $color = $isEven || $i <= 3 ? '#ffb90c' : '';
                                        echo '<span><i class="bi bi-star-fill" style="padding:0 2px; color:' . $color . ';"></i></span>';
                                    }
                                    ?>
                                    <hr>
                                    <p class="card-text p_puntos">
                                        $ <?php echo number_format($dataProduct['precio'], 0, '', '.'); ?>
                                    </p>
                                </div>
                                <a
                                    href="detallesArticulo.php?idProd=<?php echo urlencode($dataProduct["prodId"]); ?>"
                                    class="red_button btn_puntos"
                                    title="Ver <?php echo htmlspecialchars($dataProduct['nameProd'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    Ver Producto <i class="bi bi-arrow-right-circle"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No hay productos para mostrar.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include('includes/footer.html'); ?>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/styles/bootstrap4/popper.js"></script>
    <script src="assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="assets/js/loader.js"></script>
    <script src="assets/js/carrito.js"></script>
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
