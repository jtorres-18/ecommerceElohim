<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../config/config.php');

// Verificar si existe la variable token
$tokenCliente = isset($_POST['token']) ? $_POST['token'] : '';

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($tokenCliente)) {
        $sql = "SELECT producto_id, cantidad FROM pedidostemporales WHERE tokenCliente = :tokenCliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tokenCliente', $tokenCliente);

        $stmt->execute();

        $resultados = array(); // Crear una lista para almacenar los datos

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = $row; // Agregar cada fila a la lista
            }
            unset($_SESSION['tokenStoragel']);
            echo json_encode($resultados); // Enviar la lista como respuesta JSON
        } else {
            echo "vacio";
        }
    } else {
        echo "vacio"; // Si no hay token, devolver "vacio"
    }
} catch (PDOException $e) {
    echo "Error al tomar el pedido: " . $e->getMessage();
}

// Cerrar la conexión PDO correctamente
$conn = null;
?>
