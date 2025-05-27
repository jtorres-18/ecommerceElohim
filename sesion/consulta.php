<?php
include('../mostrar/config/config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "2"; // o maneja el error como prefieras
    exit;
}

// 1) Recogemos la contraseña en texto plano
$raw_pass = isset($_POST['new_pass']) ? trim($_POST['new_pass']) : '';
$id       = isset($_POST['id'])       ? intval($_POST['id'])      : 0;

if ($raw_pass === '' || $id <= 0) {
    echo "2";
    exit;
}

try {
    // 2) Hasheamos la contraseña
    $hashed_pass = password_hash($raw_pass, PASSWORD_DEFAULT);

    // 3) Conexión PDO
    $dsn  = "mysql:host={$servidor};dbname={$basededatos};charset=utf8mb4";
    $conn = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 4) Actualizamos con el hash
    $sql  = "UPDATE usuarios SET contraseña = :new_pass WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':new_pass', $hashed_pass);
    $stmt->bindParam(':id',       $id, PDO::PARAM_INT);
    $stmt->execute();

    // 5) Respondemos según filas afectadas
    echo $stmt->rowCount() > 0 ? "1" : "2";

} catch (PDOException $e) {
    // opcionalmente devolver un error más descriptivo
    echo "2";
}

// Cerramos
$conn = null;

