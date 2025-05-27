<?php
header('Content-Type: application/json');
session_start();

$index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

if (!isset($_SESSION['carrito']) || $index < 0 || $index >= count($_SESSION['carrito'])) {
    echo json_encode(["success" => false, "message" => "Índice inválido"]);
    exit;
}

unset($_SESSION['carrito'][$index]);

// Reindexar el array
$_SESSION['carrito'] = array_values($_SESSION['carrito']);

echo json_encode(["success" => true, "carrito" => $_SESSION['carrito']]);
