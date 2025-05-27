<?php
header('Content-Type: application/json');
session_start();
require_once '../mostrar/config/config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 3) {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$metodo_pago = $_POST['metodo_pago'] ?? 'efectivo';
$id_vendedor = $_SESSION['usuario_id'];
$carrito = $_SESSION['carrito'] ?? [];

// ID del cliente genérico "Mostrador" (asegúrate que exista en la BD)
$id_cliente = 42;

if (empty($carrito)) {
    echo json_encode(["success" => false, "message" => "No hay productos en la venta"]);
    exit;
}

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $total = array_sum(array_map(fn($p) => $p['cantidad'] * $p['precio'], $carrito));
    $factura = time();

    $sqlVenta = "INSERT INTO ventas (
        factura, total_venta, direccion, fecha_hora, metodo_pago, id_cliente, id_vendedor, estado
    ) VALUES (?, ?, 'LOCAL', NOW(), ?, ?, ?, 'recibido')";
    $stmtVenta = $conn->prepare($sqlVenta);
    $stmtVenta->execute([$factura, $total, $metodo_pago, $id_cliente, $id_vendedor]);
    $id_venta = $conn->lastInsertId();

    $sqlDetalle = "INSERT INTO detalles_ventas (cantidad, id_producto, id_venta)
                   VALUES (?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $prod) {
        $stmtDetalle->execute([$prod['cantidad'], $prod['id_producto'], $id_venta]);
    }

    unset($_SESSION['carrito']);

    echo json_encode(["success" => true, "message" => "Venta registrada exitosamente"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
