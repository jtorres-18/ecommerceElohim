<?php
/**
 * Funciones relacionadas con pedidos
 * 
 * Este archivo contiene funciones para gestionar los pedidos
 * de los usuarios en la tienda.
 */

/**
 * Obtiene los pedidos de un usuario
 * 
 * @param mysqli $con Conexión a la base de datos
 * @param int $usuario_id ID del usuario
 * @return mysqli_result|false Resultado de la consulta o false en caso de error
 */
function obtener_pedidos_usuario($con, $usuario_id) {
    // Consulta para obtener los pedidos básicos
    $query = "SELECT p.id, p.fecha, p.estado, p.total, p.metodo_pago,
                    (SELECT COUNT(*) FROM items_pedido WHERE pedido_id = p.id) as num_items,
                    (SELECT COUNT(*) FROM valoraciones WHERE pedido_id = p.id) > 0 as valorado
              FROM pedidos p
              WHERE p.usuario_id = ?
              ORDER BY p.fecha DESC";
    
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $con->error);
        return false;
    }
    
    $stmt->bind_param("i", $usuario_id);
    
    if (!$stmt->execute()) {
        error_log("Error en execute: " . $stmt->error);
        return false;
    }
    
    return $stmt->get_result();
}

/**
 * Obtiene el detalle de un pedido específico
 * 
 * @param mysqli $con Conexión a la base de datos
 * @param int $pedido_id ID del pedido
 * @param int $usuario_id ID del usuario (para verificar que el pedido le pertenece)
 * @return array|false Datos del pedido o false en caso de error o si no pertenece al usuario
 */
function obtener_detalle_pedido($con, $pedido_id, $usuario_id) {
    // Consulta para obtener los detalles del pedido
    $query = "SELECT p.*, 
                    v.rating as valoracion, 
                    v.comentario as comentario_valoracion, 
                    v.fecha as fecha_valoracion
              FROM pedidos p
              LEFT JOIN valoraciones v ON p.id = v.pedido_id
              WHERE p.id = ? AND p.usuario_id = ?
              LIMIT 1";
    
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $con->error);
        return false;
    }
    
    $stmt->bind_param("ii", $pedido_id, $usuario_id);
    
    if (!$stmt->execute()) {
        error_log("Error en execute: " . $stmt->error);
        return false;
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return false;
    }
    
    return $result->fetch_assoc();
}

/**
 * Obtiene los items de un pedido
 * 
 * @param mysqli $con Conexión a la base de datos
 * @param int $pedido_id ID del pedido
 * @return mysqli_result|false Resultado de la consulta o false en caso de error
 */
function obtener_items_pedido($con, $pedido_id) {
    // Consulta para obtener los items del pedido con datos del producto
    $query = "SELECT i.*, p.nameProd, p.description_Prod, f.foto1
              FROM items_pedido i
              JOIN products p ON i.producto_id = p.id
              JOIN fotoproducts f ON p.id = f.products_id
              WHERE i.pedido_id = ?";
    
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $con->error);
        return false;
    }
    
    $stmt->bind_param("i", $pedido_id);
    
    if (!$stmt->execute()) {
        error_log("Error en execute: " . $stmt->error);
        return false;
    }
    
    return $stmt->get_result();
}

/**
 * Obtiene el historial de estados de un pedido
 * 
 * @param mysqli $con Conexión a la base de datos
 * @param int $pedido_id ID del pedido
 * @return mysqli_result|false Resultado de la consulta o false en caso de error
 */
function obtener_historial_estados_pedido($con, $pedido_id) {
    // Consulta para obtener el historial de estados
    $query = "SELECT e.estado, e.fecha, e.comentario
              FROM estados_pedido e
              WHERE e.pedido_id = ?
              ORDER BY e.fecha ASC";
    
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $con->error);
        return false;
    }
    
    $stmt->bind_param("i", $pedido_id);
    
    if (!$stmt->execute()) {
        error_log("Error en execute: " . $stmt->error);
        return false;
    }
    
    return $stmt->get_result();
}

/**
 * Agrega una valoración a un pedido
 * 
 * @param mysqli $con Conexión a la base de datos
 * @param int $pedido_id ID del pedido
 * @param int $usuario_id ID del usuario
 * @param int $rating Valoración (1-5)
 * @param string $comentario Comentario opcional
 * @return bool True si se agregó correctamente, false en caso contrario
 */
function agregar_valoracion_pedido($con, $pedido_id, $usuario_id, $rating, $comentario = "") {
    // Verificar que el pedido pertenece al usuario y está entregado
    $verificacion = "SELECT id FROM pedidos WHERE id = ? AND usuario_id = ? AND estado = 'entregado'";
    $stmt_verif = $con->prepare($verificacion);
    
    if (!$stmt_verif) {
        error_log("Error en prepare verificación: " . $con->error);
        return false;
    }
    
    $stmt_verif->bind_param("ii", $pedido_id, $usuario_id);
    $stmt_verif->execute();
    $result_verif = $stmt_verif->get_result();
    
    if ($result_verif->num_rows === 0) {
        // El pedido no existe, no pertenece al usuario o no está entregado
        return false;
    }
    
    // Verificar si ya existe una valoración para este pedido
    $check_valoracion = "SELECT id FROM valoraciones WHERE pedido_id = ?";
    $stmt_check = $con->prepare($check_valoracion);
    
    if (!$stmt_check) {
        error_log("Error en prepare check valoración: " . $con->error);
        return false;
    }
    
    $stmt_check->bind_param("i", $pedido_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        // Ya existe una valoración, actualizarla en lugar de insertar una nueva
        $query = "UPDATE valoraciones SET rating = ?, comentario = ?, fecha = NOW() WHERE pedido_id = ?";
        $stmt = $con->prepare($query);
        
        if (!$stmt) {
            error_log("Error en prepare update: " . $con->error);
            return false;
        }
        
        $stmt->bind_param("isi", $rating, $comentario, $pedido_id);
    } else {
        // No existe valoración, crear una nueva
        $query = "INSERT INTO valoraciones (pedido_id, usuario_id, rating, comentario, fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $con->prepare($query);
        
        if (!$stmt) {
            error_log("Error en prepare insert: " . $con->error);
            return false;
        }
        
        $stmt->bind_param("iiis", $pedido_id, $usuario_id, $rating, $comentario);
    }
    
    if (!$stmt->execute()) {
        error_log("Error en execute: " . $stmt->error);
        return false;
    }
    
    return true;
}
