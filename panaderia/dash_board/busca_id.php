<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL para verificar las credenciales del usuario
        $sql = "SELECT * FROM products WHERE id = :id";

        // Preparar y ejecutar la consulta usando PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':id' => $id));

        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            echo json_encode($producto);
        } else {
            // Credenciales incorrectas
            echo "2";
        }
    } catch (PDOException $e) {
        echo "Error al iniciar sesión: " . $e->getMessage();
    } finally {
        // Cierra la conexión PDO correctamente
        $conn = null;
    }
}
?>