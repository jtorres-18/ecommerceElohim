<?php
require_once '../mostrar/config/config.php';

$id_venta = $_POST['id_venta'] ?? null;
$id_estado = $_POST['id_estado'] ?? null;

if (!$id_venta || !$id_estado) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE ventas SET id_estado = ? WHERE id = ?");
    $stmt->execute([$id_estado, $id_venta]);

    echo json_encode(["success" => true, "message" => "Estado actualizado"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
