<?php
session_start();
include '../config/config.php';

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['id']) || !isset($_POST['nombre']) || !isset($_POST['correo'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';

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
        
        // Verificar si la tabla tiene al menos id y nombre
        if (in_array('id', $columnas) && (in_array('nombre', $columnas) || in_array('name', $columnas))) {
            $tabla_usuario = $tabla;
            break;
        }
    }
}

if (empty($tabla_usuario)) {
    echo json_encode(['success' => false, 'message' => 'No se encontró una tabla adecuada para actualizar los datos del usuario']);
    exit;
}

// Determinar los nombres de columnas correctos
$columna_nombre = in_array('nombre', $columnas) ? 'nombre' : (in_array('name', $columnas) ? 'name' : '');
$columna_correo = in_array('correo', $columnas) ? 'correo' : (in_array('email', $columnas) ? 'email' : '');
$columna_telefono = in_array('telefono', $columnas) ? 'telefono' : (in_array('phone', $columnas) ? 'phone' : '');

// Construir la consulta SQL según las columnas disponibles
$sql_parts = [];
if (!empty($columna_nombre)) {
    $sql_parts[] = "$columna_nombre = ?";
}
if (!empty($columna_correo)) {
    $sql_parts[] = "$columna_correo = ?";
}
if (!empty($columna_telefono) && !empty($telefono)) {
    $sql_parts[] = "$columna_telefono = ?";
}

if (empty($sql_parts)) {
    echo json_encode(['success' => false, 'message' => 'No hay columnas válidas para actualizar']);
    exit;
}

$sql = "UPDATE $tabla_usuario SET " . implode(", ", $sql_parts) . " WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . mysqli_error($conn)]);
    exit;
}

// Vincular parámetros según las columnas disponibles
$tipos = '';
$params = [];

if (!empty($columna_nombre)) {
    $tipos .= 's';
    $params[] = $nombre;
}
if (!empty($columna_correo)) {
    $tipos .= 's';
    $params[] = $correo;
}
if (!empty($columna_telefono) && !empty($telefono)) {
    $tipos .= 's';
    $params[] = $telefono;
}
$tipos .= 'i';
$params[] = $id;

// Crear array de referencias para bind_param
$refs = [];
$refs[] = &$tipos;
foreach ($params as $key => $value) {
    $refs[] = &$params[$key];
}

call_user_func_array([$stmt, 'bind_param'], $refs);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Información actualizada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la información: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
