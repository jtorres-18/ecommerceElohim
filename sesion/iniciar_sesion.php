<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrado = $_POST['usuario'];
    $pass = $_POST['pass'];

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Buscar el usuario
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $registrado]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['contraseña'])) {
            session_start();
            $_SESSION["usuario_id"] = $user['id'];
            $_SESSION["tipo_usuario"] = $user['tipo_usuario'];
            $_SESSION["usuario"] = $user['usuario'];
            $_SESSION["entro"] = true;

            echo json_encode([
                "success" => true,
                "id" => $user['id'],
                "tipo_usuario" => $user['tipo_usuario']
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Usuario o contraseña incorrectos"
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Error en la conexión: " . $e->getMessage()
        ]);
    } finally {
        $conn = null;
    }
}
