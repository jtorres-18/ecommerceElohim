<?php
// recuperar_usuario.php
header('Content-Type: application/json; charset=utf-8');
include('../mostrar/config/config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['status'=>'error','message'=>'Método no permitido']);
  exit;
}

$doc = trim($_POST['documento'] ?? '');
$pwd = trim($_POST['pass']      ?? '');

if ($doc === '' || $pwd === '') {
  echo json_encode(['status'=>'error','message'=>'Datos incompletos']);
  exit;
}

try {
  $dsn = "mysql:host={$servidor};dbname={$basededatos};charset=utf8mb4";
  $pdo = new PDO($dsn, $usuario, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);

  $sql  = "SELECT nombre, usuario, correo, `contraseña`
         FROM usuarios
         WHERE documento = :doc";
$stmt = $pdo->prepare($sql);
$stmt->execute([':doc' => $doc]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // No existe ese documento
    echo json_encode(['status'=>'warning','message'=>'Documento o contraseña incorrectos']);
    exit;
}

// 2) Verificamos el hash con password_verify
if (!password_verify($pwd, $user['contraseña'])) {
    echo json_encode(['status'=>'warning','message'=>'Documento o contraseña incorrectos']);
    exit;
}

// 3) Si pasa, devolvemos datos
echo json_encode([
  'status'  => 'success',
  'nombre'  => $user['nombre'],
  'usuario' => $user['usuario'],
  'correo'  => $user['correo']
]);

} catch (PDOException $e) {
  echo json_encode(['status'=>'error','message'=>'Error BD: '.$e->getMessage()]);
}

