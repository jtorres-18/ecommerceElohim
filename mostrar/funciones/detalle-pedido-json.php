<?php

session_start();
header('Content-Type: application/json');

// 1) Autorización
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success'=>false,'message'=>'No autorizado']);
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
error_log("USUARIO_ID: $usuario_id");

// 2) Conexión
require_once __DIR__ . '/../config/config.php';
$con = new mysqli($servidor, $usuario, $password, $basededatos);
if ($con->connect_error) {
    echo json_encode(['success'=>false,'message'=>'Error de conexión a la base de datos']);
    exit;
}
error_log("Conexión a DB OK");

// 3) Parámetro: factura
if (empty($_GET['factura'])) {
    echo json_encode(['success'=>false,'message'=>'Necesitamos un número de factura']);
    exit;
}
$factura = $_GET['factura'];
error_log("Factura recibida: $factura");

// 4) Obtener ID de la venta
$stmt = $con->prepare(
    "SELECT id, fecha_hora, total_venta, metodo_pago, direccion, id_estado
     FROM ventas
     WHERE factura = ? AND id_cliente = ?
     LIMIT 1"
);
$stmt->bind_param("si", $factura, $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(['success'=>false,'message'=>'Factura no encontrada']);
    exit;
}
$venta = $res->fetch_assoc();
$venta_id = (int)$venta['id'];
error_log("VENTA_ID: $venta_id");

// 5) Estado nombre
$stmt2 = $con->prepare("SELECT nombre FROM estados WHERE id = ?");
$stmt2->bind_param("i", $venta['id_estado']);
$stmt2->execute();
$estado_row = $stmt2->get_result()->fetch_assoc();
$estado_nombre = $estado_row['nombre'] ?? '';
error_log("Estado: $estado_nombre");

// 6) Detalles de productos
$sql = "
    SELECT dv.cantidad, p.nameProd, p.precio
    FROM detalles_ventas dv
    JOIN products p ON dv.id_producto = p.id
    WHERE dv.id_venta = ?
";

$stmt3 = $con->prepare($sql);
$stmt3->bind_param("i", $venta_id);
$stmt3->execute();
$resultado = $stmt3->get_result();

error_log("SQL para productos: " . str_replace("?", $venta_id, $sql));

if (!$resultado) {
    error_log("Error en la consulta SQL: " . $con->error);
}

$productos = [];
$subtotal  = 0;

if ($resultado && $resultado->num_rows > 0) {
    error_log("Encontrados " . $resultado->num_rows . " productos para la venta ID: $venta_id");
    while ($row = $resultado->fetch_assoc()) {
        error_log("Producto encontrado: " . json_encode($row));
        $cant          = (int)$row['cantidad'];
        $precio        = (float)$row['precio'];
        $subtotal_item = $cant * $precio;

        $subtotal += $subtotal_item;

        $productos[] = [
            'nameProd' => $row['nameProd'],
            'cantidad' => $cant,
            'precio'   => $precio,
            'subtotal' => $subtotal_item
        ];
    }
} else {
    error_log("No se encontraron productos para la venta ID: $venta_id");
    // Verificar si la tabla detalles_ventas tiene los datos correctos
    $check_sql = "SELECT * FROM detalles_ventas WHERE id_venta = $venta_id";
    $check_result = $con->query($check_sql);
    if ($check_result && $check_result->num_rows > 0) {
        error_log("Hay " . $check_result->num_rows . " registros en detalles_ventas pero no se pudieron unir con products");
        while ($row = $check_result->fetch_assoc()) {
            error_log("Detalle venta: " . json_encode($row));
        }
    } else {
        error_log("No hay registros en detalles_ventas para esta venta");
    }
}

$envio       = 3000;
$total_final = $subtotal + $envio;

echo json_encode([
    'success'               => true,
    'factura'               => $factura,
    'fecha_hora'            => $venta['fecha_hora'],
    'estado'                => $estado_nombre,
    'metodo_pago'           => $venta['metodo_pago'],
    'direccion_envio'       => $venta['direccion'],
    'productos'             => $productos,
    'subtotal'              => $subtotal,
    'envio'                 => $envio,
    'total_venta'           => $total_final,
    'nota'                  => '',
    'direccion_facturacion' => ''
]);
