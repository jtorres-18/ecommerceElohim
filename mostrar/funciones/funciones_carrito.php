<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir el archivo de configuración
require_once __DIR__ . '/../config/config.php';

// Establecer las cabeceras para indicar que la respuesta es en formato JSON
header('Content-Type: application/json');

// Función para registrar errores
function logError($message) {
    error_log(date('Y-m-d H:i:s') . " - " . $message . "\n", 3, __DIR__ . '/../logs/carrito_errors.log');
}

// Verificar la conexión
if (!isset($con) || !$con) {
    logError("Error de conexión a la base de datos");
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener total de productos
if (isset($_POST["accion"]) && $_POST["accion"] == "obtenerTotalProductos") {
    try {
        $tokenCliente = isset($_POST['tokenCliente']) ? $_POST['tokenCliente'] : '';
        
        if (empty($tokenCliente)) {
            echo json_encode(['total' => 0]);
            exit;
        }
        
        $consulta = "SELECT SUM(cantidad) AS total FROM pedidostemporales WHERE tokenCliente=?";
        $stmt = mysqli_prepare($con, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $tokenCliente);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $fila = mysqli_fetch_assoc($resultado);
        
        echo json_encode(['total' => $fila['total'] ? $fila['total'] : 0]);
    } catch (Exception $e) {
        logError("Error en obtenerTotalProductos: " . $e->getMessage());
        echo json_encode(['error' => 'Error al procesar la solicitud', 'total' => 0]);
    }
    exit;
}

// Aumentar cantidad
if (isset($_POST["aumentarCantidad"])) {
    try {
        $idProd = isset($_POST['idProd']) ? $_POST['idProd'] : '';
        $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
        $tokenCliente = isset($_POST['tokenCliente']) ? $_POST['tokenCliente'] : '';
        $cantidaProducto = isset($_POST['aumentarCantidad']) ? $_POST['aumentarCantidad'] : 1;
        
        if (empty($idProd) || empty($tokenCliente)) {
            echo json_encode(['estado' => 'ERROR', 'mensaje' => 'Datos incompletos']);
            exit;
        }
        
        $UpdateCant = "UPDATE pedidostemporales 
                SET cantidad = ?
                WHERE tokenCliente = ?
                AND id = ?";
        $stmt = mysqli_prepare($con, $UpdateCant);
        mysqli_stmt_bind_param($stmt, "iss", $cantidaProducto, $tokenCliente, $idProd);
        mysqli_stmt_execute($stmt);
        
        $responseData = array(
            'estado' => 'OK',
            'totalPagar' => totalAccionAumentarDisminuir($con, $tokenCliente)
        );
        
        echo json_encode($responseData);
    } catch (Exception $e) {
        logError("Error en aumentarCantidad: " . $e->getMessage());
        echo json_encode(['estado' => 'ERROR', 'mensaje' => 'Error al procesar la solicitud']);
    }
    exit;
}

// Agregar al carrito
if (isset($_POST["accion"]) && $_POST["accion"] == "addCar") {
    try {
        $_SESSION['tokenStoragel'] = $_POST['tokenCliente'];
        $idProduct = isset($_POST['idProduct']) ? $_POST['idProduct'] : null;
        $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
        $tokenCliente = isset($_POST['tokenCliente']) ? $_POST['tokenCliente'] : null;
        $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
        
        if (!$idProduct || !$precio || !$tokenCliente) {
            logError("Datos incompletos: idProduct=$idProduct, precio=$precio, tokenCliente=$tokenCliente");
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }
        
        // Verificar si ya existe el producto en el carrito
        $consulta = "SELECT * FROM pedidostemporales WHERE tokenCliente=? AND producto_id=?";
        $stmt = mysqli_prepare($con, $consulta);
        mysqli_stmt_bind_param($stmt, "ss", $tokenCliente, $idProduct);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($resultado) > 0) {
            // Si ya existe, actualizar la cantidad
            $fila = mysqli_fetch_assoc($resultado);
            $nuevaCantidad = $fila['cantidad'] + $cantidad;
            
            $actualizar = "UPDATE pedidostemporales SET cantidad=? WHERE producto_id=? AND tokenCliente=?";
            $stmt = mysqli_prepare($con, $actualizar);
            mysqli_stmt_bind_param($stmt, "iss", $nuevaCantidad, $idProduct, $tokenCliente);
            mysqli_stmt_execute($stmt);
        } else {
            // Si no existe, insertar nuevo registro
            $insertar = "INSERT INTO pedidostemporales (producto_id, cantidad, tokenCliente) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertar);
            mysqli_stmt_bind_param($stmt, "sis", $idProduct, $cantidad, $tokenCliente);
            mysqli_stmt_execute($stmt);
        }
        
        // Obtener el total de productos en el carrito
        $consulta = "SELECT SUM(cantidad) AS total FROM pedidostemporales WHERE tokenCliente=?";
        $stmt = mysqli_prepare($con, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $tokenCliente);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $fila = mysqli_fetch_assoc($resultado);
        
        echo $fila['total'] ? $fila['total'] : '0';
    } catch (Exception $e) {
        logError("Error en addCar: " . $e->getMessage());
        echo json_encode(['error' => 'Error al procesar la solicitud']);
    }
    exit;
}

// Disminuir cantidad
if (isset($_POST["accion"]) && $_POST["accion"] == "disminuirCantidad") {
    try {
        $_SESSION['tokenStoragel'] = $_POST['tokenCliente'];
        $idProd = mysqli_real_escape_string($con, $_POST['idProd']);
        $precio = mysqli_real_escape_string($con, $_POST['precio']);
        $tokenCliente = mysqli_real_escape_string($con, $_POST['tokenCliente']);
        $cantidad_Disminuida = mysqli_real_escape_string($con, $_POST['cantidad_Disminuida']);
        
        if ($cantidad_Disminuida == 0) {
            $eliminar = "DELETE FROM pedidostemporales WHERE tokenCliente=? AND id=?";
            $stmt = mysqli_prepare($con, $eliminar);
            mysqli_stmt_bind_param($stmt, "ss", $tokenCliente, $idProd);
            mysqli_stmt_execute($stmt);
        } else {
            $actualizar = "UPDATE pedidostemporales SET cantidad=? WHERE tokenCliente=? AND id=?";
            $stmt = mysqli_prepare($con, $actualizar);
            mysqli_stmt_bind_param($stmt, "iss", $cantidad_Disminuida, $tokenCliente, $idProd);
            mysqli_stmt_execute($stmt);
        }
        
        $responseData = array(
            'totalProductos' => totalProductosSeleccionados($con, $tokenCliente),
            'totalPagar' => totalAccionAumentarDisminuir($con, $tokenCliente),
            'estado' => 'OK'
        );
        
        echo json_encode($responseData);
    } catch (Exception $e) {
        logError("Error en disminuirCantidad: " . $e->getMessage());
        echo json_encode(['error' => 'Error al procesar la solicitud']);
    }
    exit;
}

// Borrar producto
if (isset($_POST["accion"]) && $_POST["accion"] == "borrarproductoModal") {
    try {
        $nameTokenProducto = $_POST['tokenCliente'];
        $idProduct = $_POST['idProduct'];
        
        $eliminar = "DELETE FROM pedidostemporales WHERE id=?";
        $stmt = mysqli_prepare($con, $eliminar);
        mysqli_stmt_bind_param($stmt, "s", $idProduct);
        mysqli_stmt_execute($stmt);
        
        $respData = array(
            'totalProductos' => totalProductosSeleccionados($con, $nameTokenProducto),
            'totalProductoSeleccionados' => totalProductosBD($con, $nameTokenProducto),
            'totalPagar' => totalAccionAumentarDisminuir($con, $nameTokenProducto),
            'estado' => 'OK'
        );
        
        echo json_encode($respData);
    } catch (Exception $e) {
        logError("Error en borrarproductoModal: " . $e->getMessage());
        echo json_encode(['error' => 'Error al procesar la solicitud']);
    }
    exit;
}

// Limpiar carrito
if (isset($_POST["accion"]) && $_POST["accion"] == "limpiarTodoElCarrito") {
    try {
        unset($_SESSION['tokenStoragel']);
        echo json_encode(['mensaje' => 1]);
    } catch (Exception $e) {
        logError("Error en limpiarTodoElCarrito: " . $e->getMessage());
        echo json_encode(['error' => 'Error al procesar la solicitud']);
    }
    exit;
}

// Funciones auxiliares
function totalProductosBD($con, $nameTokenProducto) {
    $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd FROM pedidostemporales WHERE tokenCliente=? GROUP BY tokenCliente";
    $stmt = mysqli_prepare($con, $sqlTotalProduct);
    mysqli_stmt_bind_param($stmt, "s", $nameTokenProducto);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
        return $fila["totalProd"];
    } else {
        return 0;
    }
}

function totalAccionAumentarDisminuir($con, $tokenCliente) {
    $SqlDeudaTotal = "
        SELECT SUM(p.precio * pt.cantidad) AS totalPagar 
        FROM products AS p
        INNER JOIN pedidostemporales AS pt
        ON p.id = pt.producto_id
        WHERE pt.tokenCliente = ?";
    
    $stmt = mysqli_prepare($con, $SqlDeudaTotal);
    mysqli_stmt_bind_param($stmt, "s", $tokenCliente);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
        return $fila['totalPagar'];
    } else {
        return 0;
    }
}

function totalProductosSeleccionados($con, $tokenCliente) {
    $consulta = "SELECT COUNT(*) AS total FROM pedidostemporales WHERE tokenCliente=?";
    $stmt = mysqli_prepare($con, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $tokenCliente);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
        return $fila['total'];
    } else {
        return 0;
    }
}
