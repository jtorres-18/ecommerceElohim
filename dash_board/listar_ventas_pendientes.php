<?php
require_once '../mostrar/config/config.php';

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM ventas WHERE estado = 'pendiente'");
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "ventas" => $ventas]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
