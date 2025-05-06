<?php
include('../config/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $metodo_pago = $_POST["metodo_pago"];
    $venta = $_POST["total_venta"];
    $total_venta = str_replace("$", $venta);
    $factura = $_POST["factura"];
    $id_cliente = $_POST["id_cliente"];
    try {
        // Configurar la zona horaria de Colombia
        date_default_timezone_set('America/Bogota');

        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Establecer la configuración regional a español
        setlocale(LC_TIME, 'es_CO.UTF-8', 'es_CO', 'es_ES.UTF-8', 'es_ES');

        // Obtener el nombre del día de la semana en español
        $dia = strftime('%A');

        $sql = "INSERT INTO ventas (factura, total_venta, direccion, fecha_hora, metodo_pago, id_cliente, dia) VALUES (:factura, :total_venta, :direccion, NOW(), :metodo_pago, :id_cliente, :dia)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':factura', $factura);
        $stmt->bindParam(':total_venta', $total_venta);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':metodo_pago',  $metodo_pago);
        $stmt->bindParam(':id_cliente',  $id_cliente);
        $stmt->bindParam(':dia',  $dia);
        $stmt->execute();

        $sql = "SELECT id FROM ventas WHERE factura = :factura";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':factura', $factura);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $venta = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($venta);
        }

    } catch (PDOException $e) {
        echo "Error al guardar los datos: " . $e->getMessage();
    }

    // Restaurar la configuración regional y la zona horaria
    setlocale(LC_TIME, 'en_US.UTF-8'); // Cambiar 'en_US.UTF-8' según tu configuración regional original
    date_default_timezone_set('UTC'); // Cambiar 'UTC' según tu zona horaria original

    // Cerrar la conexión PDO correctamente
    $conn = null;
}
?>
