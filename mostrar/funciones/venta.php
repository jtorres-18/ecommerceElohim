<?php
header('Content-Type: application/json');
include('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $direccion = $_POST["direccion"] ?? '';
        $telefono = $_POST["telefono"] ?? '';
        $metodo_pago = $_POST["metodo_pago"] ?? '';
        $venta = $_POST["total_venta"] ?? '0';
        $factura = $_POST["factura"] ?? '';
        $id_cliente = $_POST["id_cliente"] ?? '';

        $total_venta = str_replace(["$", "."], "", $venta); // quitar símbolos y puntos
        date_default_timezone_set('America/Bogota');
        setlocale(LC_TIME, 'es_CO.UTF-8');

        $dia = strftime('%A');

        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO ventas (factura, total_venta, direccion, fecha_hora, metodo_pago, id_cliente)
        VALUES (:factura, :total_venta, :direccion, NOW(), :metodo_pago, :id_cliente)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':factura', $factura);
        $stmt->bindParam(':total_venta', $total_venta);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':metodo_pago',  $metodo_pago);
        $stmt->bindParam(':id_cliente',  $id_cliente);

        $stmt->execute();

        $stmt = $conn->prepare("SELECT id FROM ventas WHERE factura = :factura LIMIT 1");
        $stmt->bindParam(':factura', $factura);
        $stmt->execute();
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "id" => $venta["id"] ?? null]);

    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    } finally {
        $conn = null;
    }
}
