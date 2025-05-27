<?php
session_start();
include '../config/config.php';

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['id']) || !isset($_POST['password_actual']) || !isset($_POST['password_nuevo'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$id = $_POST['id'];
$password_actual = $_POST['password_actual'];
$password_nuevo = $_POST['password_nuevo'];

// Conectar a la base de datos
$conn = mysqli_connect($servidor, $usuario, $password, $basededatos);

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . mysqli_connect_error()]);
    exit;
}

// Verificar qué tablas existen en la base de datos
$tablas_result = mysqli_query($conn, "SHOW TABLES");
$tablas = [];
while ($tabla = mysqli_fetch_array($tablas_result)) {
    $tablas[] = $tabla[0];
}

// Determinar la tabla correcta para actualizar
$tabla_usuario = '';
$tablas_posibles = ['usuarios', 'clientes', 'users', 'user', 'cliente'];

foreach ($tablas_posibles as $tabla) {
    if (in_array($tabla, $tablas)) {
        // Verificar si la tabla tiene las columnas necesarias
        $columnas_result = mysqli_query($conn, "DESCRIBE $tabla");
        $columnas = [];
        while ($columna = mysqli_fetch_array($columnas_result)) {
            $columnas[] = $columna[0];
        }
        
        // Verificar si la tabla tiene al menos id y contraseña
        if (in_array('id', $columnas) && 
            (in_array('password', $columnas) || in_array('contraseña', $columnas) || in_array('contrasena', $columnas) || in_array('clave', $columnas))) {
            $tabla_usuario = $tabla;
            break;
        }
    }
}

if (empty($tabla_usuario)) {
    echo json_encode(['success' => false, 'message' => 'No se encontró una tabla adecuada para actualizar la contraseña']);
    exit;
}

// Determinar el nombre de la columna de contraseña
$columna_password = '';
if (in_array('password', $columnas)) {
    $columna_password = 'password';
} elseif (in_array('contraseña', $columnas)) {
    $columna_password = 'contraseña';
} elseif (in_array('contrasena', $columnas)) {
    $columna_password = 'contrasena';
} elseif (in_array('clave', $columnas)) {
    $columna_password = 'clave';
}

// Verificar la contraseña actual
$sql = "SELECT $columna_password FROM $tabla_usuario WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

$usuario = mysqli_fetch_assoc($resultado);
$password_guardada = $usuario[$columna_password];

// Verificar si la contraseña está encriptada
$password_correcta = false;

// Intentar con password_verify (para contraseñas con hash moderno)
if (function_exists('password_verify') && password_verify($password_actual, $password_guardada)) {
    $password_correcta = true;
}
// Intentar con md5 (método antiguo pero común)
elseif (md5($password_actual) === $password_guardada) {
    $password_correcta = true;
}
// Intentar con comparación directa (no recomendado pero posible en sistemas antiguos)
elseif ($password_actual === $password_guardada) {
    $password_correcta = true;
}

if (!$password_correcta) {
    echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta']);
    exit;
}

// Encriptar la nueva contraseña
$password_hash = '';
if (function_exists('password_hash')) {
    // Usar el método moderno si está disponible
    $password_hash = password_hash($password_nuevo, PASSWORD_DEFAULT);
} else {
    // Usar md5 como fallback (no recomendado pero compatible con sistemas antiguos)
    $password_hash = md5($password_nuevo);
}

// Actualizar la contraseña
$sql = "UPDATE $tabla_usuario SET $columna_password = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "si", $password_hash, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
