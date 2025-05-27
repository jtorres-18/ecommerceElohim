<?php
// api/apiEncargos.php
header('Content-Type: application/json');

try {
    // Validar que se envía el parámetro
    if (empty($_GET['factura'])) {
        throw new Exception("Parámetro 'factura' es requerido");
    }
    $factura = $_GET['factura'];

    // Conexión a la base de datos
    $conn = new PDO("mysql:host=localhost;dbname=gelohimg_elohim", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta con JOIN para traer el nombre del estado
    $sql = "SELECT v.factura, e.nombre AS estado
            FROM ventas v
            INNER JOIN estados e ON v.id_estado = e.id
            WHERE v.factura = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$factura]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo json_encode([
            "success" => false,
            "message" => "No se encontró la factura $factura"
        ]);
        exit;
    }   

    // Respuesta con factura y nombre del estado
    echo json_encode([
        "success" => true,
        "factura" => $resultado['factura'],
        "estado"  => $resultado['estado']
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}