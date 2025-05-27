<?php
/**
 * API del Chatbot - Endpoint principal
 * 
 * Este archivo procesa las solicitudes del chatbot y devuelve respuestas
 */

// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivo de respuestas
require_once __DIR__ . '/responses.php';

// Verificar si es una solicitud OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si se recibió un mensaje
if (!isset($data['message']) || empty($data['message'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 400,
        'message' => 'Se requiere un mensaje'
    ]);
    exit;
}

// Procesar el mensaje y obtener respuesta
$message = trim($data['message']);
$response = getResponse($message);

// Devolver respuesta
http_response_code(200);
echo json_encode([
    'status' => 200,
    'data' => $response
]);
