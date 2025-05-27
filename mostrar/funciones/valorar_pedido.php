<?php
/**
 * API para valorar pedidos
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['pedido_id']) || !isset($_POST['rating'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Obtener los datos del formulario
$pedido_id = (int)$_POST['pedido_id'];
$rating = (int)$_POST['rating'];
$comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';
$usuario_id = $_SESSION['usuario_id'];

// Validar el rating
if ($rating < 1 || $rating > 5) {
    echo json_encode([
        'success' => false,
        'message' => 'La valoración debe estar entre 1 y 5'
    ]);
    exit;
}

// Incluir archivo de funciones
require_once 'funciones_pedidos.php';
require_once '../config/config.php';

// Intentar guardar la valoración
$resultado = agregar_valoracion_pedido($con, $pedido_id, $usuario_id, $rating, $comentario);

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Valoración guardada correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo guardar la valoración. Verifica que el pedido exista y esté entregado.'
    ]);
}
