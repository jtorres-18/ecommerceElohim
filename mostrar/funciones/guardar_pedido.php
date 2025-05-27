<?php
include('../config/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $cantidad = $_POST["cantidad"];
    $id_producto = $_POST["id_producto"];
    $id_venta = $_POST["id_venta"];
    
try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO detalles_ventas (cantidad, id_producto, id_venta) VALUES (:cantidad, :id_producto, :id_venta)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->bindParam(':id_venta', $id_venta); 
    $stmt->execute();
    
    echo '1';
    

} catch (PDOException $e) {
    echo "Error al guardar los datos: " . $e->getMessage();
}

// Cerrar la conexi贸n PDO correctamente
$conn = null;
}
?>
