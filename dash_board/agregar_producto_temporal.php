<?php
header('Content-Type: application/json');
session_start();
require_once '../mostrar/config/config.php';

$id_producto = $_POST['id_producto'];
$cantidad = (int)$_POST['cantidad'];

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id, codigo, nameProd, precio FROM products WHERE id = ? OR codigo = ?");
    $stmt->execute([$id_producto, $id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
        exit;
    }

    $subtotal = $producto['precio'] * $cantidad;

    $_SESSION['carrito'][] = [
        'codigo' => $producto['codigo'],
        'id_producto' => $producto['id'],
        'nombre' => $producto['nameProd'],
        'precio' => $producto['precio'],
        'cantidad' => $cantidad,
        'subtotal' => $subtotal
    ];

    echo json_encode([
        "success" => true,
        "carrito" => $_SESSION['carrito']
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}


