<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../config/config.php');

/**
 * Funcion para obtener todos los productos
 * de mi tienda
 */
if (!function_exists('getProductData')) {
    function getProductData($con)
    {
    $sqlProducts = ("
        SELECT 
            p.id AS prodId,
            p.nameProd,
            p.precio,
            f.foto1
        FROM 
            products AS p
        INNER JOIN
            fotoproducts AS f
        ON 
            p.id = f.products_id
            where p.estado = 1;
    ");
    $queryProducts = mysqli_query($con, $sqlProducts);

    if (!$queryProducts) {
        return false;
    }
    return $queryProducts;
    }
}


/**
 * Funcion para obtener  los productos de categoria panaderia
 * de mi tienda
 */
function getProductDataPanaderia($con)
{
    $sqlProductsPanaderia = ("
        SELECT 
            p.id AS prodId,
            p.nameProd,
            p.precio,
            f.foto1
        FROM 
            products AS p
        INNER JOIN
            fotoproducts AS f
        ON 
            p.id = f.products_id
        WHERE
            p.categoria = 1
            and p.estado = 1;
    ");
    $queryProductsPanaderia = mysqli_query($con, $sqlProductsPanaderia);

    if (!$queryProductsPanaderia) {
        return false;
    }
    // Si todo está bien, devuelves el resultado del query
    return $queryProductsPanaderia;
}
/**
 * Funcion para obtener  los productos de categoria panaderia
 * de mi tienda
 */
function getProductDataReposteria($con)
{
    $sqlProductsReposteria = ("
        SELECT 
            p.id AS prodId,
            p.nameProd,
            p.precio,
            f.foto1
        FROM 
            products AS p
        INNER JOIN
            fotoproducts AS f
        ON 
            p.id = f.products_id
        WHERE
            p.categoria = 2
            and p.estado = 1;
    ");
    $queryProductsReposteria = mysqli_query($con, $sqlProductsReposteria);

    if (!$queryProductsReposteria ) {
        return false;
    }
    // Si todo está bien, devuelves el resultado del query
    return $queryProductsReposteria ;
}



/**
 * Detalles del producto seleccionado
 */
function detalles_producto_seleccionado($con, $idProd)
{
    $sqlDetalleProducto = ("
        SELECT 
            p.id AS prodId,
            p.nameProd,
            p.description_Prod,
            p.precio,
            
            f.foto1,
            f.foto2,
            f.foto3
        FROM 
            products AS p
        INNER JOIN
            fotoproducts AS f
        ON 
            p.id = f.products_id
            AND p.id ='" . $idProd . "'
            LIMIT 1;
	");
    $queryProductoSeleccionado = mysqli_query($con, $sqlDetalleProducto);
    if (!$queryProductoSeleccionado) {
        return false;
    }
    return $queryProductoSeleccionado;
}

/**
 * Funciona para validar si el carrito tiene algun producto
 */
function validando_carrito()
{
    if (isset($_SESSION['tokenStoragel']) == "") {
        return '
            <div class="row align-items-center">
                <div class="col-lg-12 text-center mt-5">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Ops.!</strong> Tu carrito está vacío.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-12 text-center mt-5 mb-5">
                    <a href="/panaderia/mostrar/productos.php" class="red_button btn_raza" style="padding: 5px 20px;">
                    <i class="bi bi-arrow-left-circle"></i>  Volver a la Tienda</a>
                </div>
            </div>';
    }
}


/**
 * Retornando productos del carrito de compra
 */


function mi_carrito_de_compra($con)
{
    if (isset($_SESSION['tokenStoragel']) == "") {
        return 0;
    }

    $token = $_SESSION['tokenStoragel'];
    if (empty($token)) {
        return 0;
    }

    $sqlCarritoCompra = "SELECT 
                        p.id AS prodId,
                        p.nameProd,
                        p.description_Prod,
                        p.precio,
                        f.foto1,
                        pt.id AS tempId,
                        pt.producto_id,
                        pt.cantidad,
                        pt.tokenCliente
                    FROM 
                        products AS p
                    INNER JOIN fotoproducts AS f ON p.id = f.products_id
                    INNER JOIN pedidostemporales AS pt ON p.id = pt.producto_id
                    WHERE pt.tokenCliente = ?";
    
    $stmt = mysqli_prepare($con, $sqlCarritoCompra);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $queryCarrito = mysqli_stmt_get_result($stmt);

    if (!$queryCarrito) {
        error_log("Error en consulta carrito: " . mysqli_error($con));
        return false;
    }

    return $queryCarrito;
}

function totalAcumuladoDeuda($con)
{
    if (isset($_SESSION['tokenStoragel']) != "") {
        $SqlDeudaTotal = "
        SELECT SUM(p.precio * pt.cantidad) AS totalPagar 
        FROM products AS p
        INNER JOIN pedidostemporales AS pt
        ON p.id = pt.producto_id
        WHERE pt.tokenCliente = '" . $_SESSION["tokenStoragel"] . "'
        ";
        $jqueryDeuda = mysqli_query($con, $SqlDeudaTotal);
        $dataDeuda = mysqli_fetch_array($jqueryDeuda);
        return  number_format($dataDeuda['totalPagar'], 0, '', '.');
    }
}

/**
 * Función para mostrar el icono del carrito con la cantidad de productos
 */
function iconoCarrito($con) {
    if (!isset($_SESSION['tokenStoragel']) || empty($_SESSION['tokenStoragel'])) {
        return '<span class="cart-icon">0</span>';
    }
    
    $token = $_SESSION['tokenStoragel'];
    $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd FROM pedidostemporales WHERE tokenCliente = ? GROUP BY tokenCliente";
    
    $stmt = mysqli_prepare($con, $sqlTotalProduct);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && $row = mysqli_fetch_assoc($result)) {
            return '<span class="cart-icon">' . $row['totalProd'] . '</span>';
        }
    }
    
    return '<span class="cart-icon">0</span>';
}
