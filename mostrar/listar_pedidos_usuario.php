<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$estado = $_GET['estado'] ?? 'todos';
$periodo = $_GET['periodo'] ?? '3m';

$fecha_limite = match ($periodo) {
    '1s' => date('Y-m-d', strtotime('-7 days')),
    '1m' => date('Y-m-d', strtotime('-1 month')),
    default => date('Y-m-d', strtotime('-3 months')),
};

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT v.*, e.nombre AS estado_nombre
              FROM ventas v
              JOIN estados e ON v.id_estado = e.id
              WHERE v.id_cliente = :id_usuario AND v.fecha_hora >= :fecha";

    if ($estado !== 'todos') {
        $query .= " AND e.nombre = :estado";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha_limite);

    if ($estado !== 'todos') {
        $stmt->bindParam(':estado', $estado);
    }

    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "pedidos" => $pedidos]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
