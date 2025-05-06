<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrado = $_POST['usuario'];
    $pass = $_POST['pass']; // Contraseña proporcionada por el usuario

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL para verificar las credenciales del usuario
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";

        // Preparar y ejecutar la consulta usando PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':usuario' => $registrado));

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($pass, $usuario['contraseña'])) {
            session_start();
            $_SESSION['usuario'] = $registrado;
            $_SESSION['entro'] = true;
            echo json_encode($usuario);
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