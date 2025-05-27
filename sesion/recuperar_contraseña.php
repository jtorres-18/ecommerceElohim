<?php
// recuperar_correo.php
header('Content-Type: application/json; charset=utf-8');
include('../mostrar/config/config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Método no permitido']);
    exit;
}

$email = isset($_POST['correo']) ? trim($_POST['correo']) : '';

if ($email === '') {
    echo json_encode(['status'=>'error','message'=>'Correo vacío']);
    exit;
}

try {
    $dsn = "mysql:host={$servidor};dbname={$basededatos};charset=utf8mb4";
    $pdo = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Limit 1 y seleccionamos sólo los campos que necesitamos
    $sql = "SELECT id, nombre, usuario, correo 
            FROM usuarios 
            WHERE correo = :correo 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':correo' => $email]);

    // Usamos fetch() en lugar de rowCount()
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Encontró al usuario
        echo json_encode([
          'status' => 'success',
          'data'   => $user
        ]);
    } else {
        // No hay coincidencias
        echo json_encode([
          'status'  => 'warning',
          'message' => 'Correo no registrado'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
      'status'  => 'error',
      'message' => 'Error BD: ' . $e->getMessage()
    ]);
}

