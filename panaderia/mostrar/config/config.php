<?php
$usuario = "root"; // Reemplaza con el nombre de usuario correcto
$password = ""; // Reemplaza con la contraseña correcta
$servidor = "localhost:3306";
$basededatos = "gelohimg9_elohim";

// Función para conectar a la base de datos
if (!function_exists('conectar')) {
    function conectar() {
        global $usuario, $password, $servidor, $basededatos;
        
        // Crear la conexión
        $con = mysqli_connect($servidor, $usuario, $password, $basededatos);
        
        // Verificar la conexión
        if (!$con) {
            die("Error al conectar a la Base de Datos: " . mysqli_connect_error());
        }
        
        return $con;
    }
}

// Crear la conexión global
$con = conectar();

//echo "Conexión exitosa a la Base de Datos";

