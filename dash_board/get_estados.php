<?php
require_once '../mostrar/config/config.php';

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT id, nombre FROM estados ORDER BY id ASC");
    $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "estados" => $estados]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
