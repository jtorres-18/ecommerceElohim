<?php
require_once '../mostrar/config/config.php';

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT v.*, e.nombre AS estado_nombre 
                          FROM ventas v 
                          JOIN estados e ON v.id_estado = e.id 
                          ORDER BY v.fecha_hora DESC");

    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "ventas" => $ventas]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}



