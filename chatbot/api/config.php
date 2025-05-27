<?php
/**
 * Configuración de la API del chatbot
 * 
 * Este archivo contiene la configuración básica para la API
 */

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de errores
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Configuración de sesión
session_start();

// Función para registrar errores
function logError($message, $file = null, $line = null) {
    $logFile = __DIR__ . '/../logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    
    if ($file && $line) {
        $logMessage .= " in $file on line $line";
    }
    
    // Crear directorio de logs si no existe
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    // Escribir en el archivo de log
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
}

// Manejador de errores personalizado
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    logError($errstr, $errfile, $errline);
    return true;
});

// Manejador de excepciones personalizado
set_exception_handler(function($exception) {
    logError($exception->getMessage(), $exception->getFile(), $exception->getLine());
});
