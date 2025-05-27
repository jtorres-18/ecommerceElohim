<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST["nombre"];
    $documento = $_POST["documento"];
    $email = $_POST["email"];
    $usuari = $_POST["usuario"];
    $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $tipo_usuario = 3;

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultas para verificar si el correo, usuario o documento ya existen en la base de datos
        $queryEmail = "SELECT correo FROM usuarios WHERE correo = :email";
        $queryUsuario = "SELECT usuario FROM usuarios WHERE usuario = :usuari";
        $queryDocumento = "SELECT documento FROM usuarios WHERE documento = :documento";

        $stmtEmail = $conn->prepare($queryEmail);
        $stmtEmail->bindParam(':email', $email);
        $stmtEmail->execute();

        $stmtUsuario = $conn->prepare($queryUsuario);
        $stmtUsuario->bindParam(':usuari', $usuari);
        $stmtUsuario->execute();

        $stmtDocumento = $conn->prepare($queryDocumento);
        $stmtDocumento->bindParam(':documento', $documento);
        $stmtDocumento->execute();

        if ($stmtEmail->rowCount() > 0) {
            
        } elseif ($stmtUsuario->rowCount() > 0) {
            echo '4'; // Usuario ya existe
        } elseif ($stmtDocumento->rowCount() > 0) {
            echo '3'; // Documento ya existe
        } else {
            // Insertar un nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (nombre, documento, correo, usuario, contraseña, tipo_usuario) 
                    VALUES (:nombre, :documento, :email, :usuari,  :pass, :tipo_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':usuari', $usuari);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->execute();

            echo '1'; // Registro exitoso
        }
    } catch (PDOException $e) {
        echo "Error al guardar los datos: " . $e->getMessage();
    } finally {
        // Cerrar la conexión PDO correctamente
        $conn = null;
    }
}
?>