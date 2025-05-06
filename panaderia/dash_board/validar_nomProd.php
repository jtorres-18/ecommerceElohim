<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameProd = $_POST["nameProd"];

    // Verificando si existe algún producto en la base de datos con dicho nombre asignado
    // Preparamos un arreglo que contendrá toda la información
    $jsonData = array();
    
    // Utilizamos una consulta preparada para evitar inyecciones SQL
    $selectQuery = "SELECT nameProd FROM products WHERE nameProd = ?";
    
    // Preparamos la consulta
    $stmt = mysqli_prepare($con, $selectQuery);

    // Vinculamos los parámetros
    mysqli_stmt_bind_param($stmt, "s", $nameProd);

    // Ejecutamos la consulta
    mysqli_stmt_execute($stmt);

    // Almacenamos el resultado
    mysqli_stmt_store_result($stmt);

    // Obtenemos el número de filas
    $totalProductos = mysqli_stmt_num_rows($stmt);

    // Validamos que la consulta haya retornado información
    if ($totalProductos <= 0) {
        $jsonData['success'] = 0;
        $jsonData['message'] = '';
    } else {
        // Si hay datos entonces retornamos algo
        $jsonData['success'] = 1;
        $jsonData['message'] = '<p style="color:red;">Ya existe este nombre del producto <strong>(' . $nameProd. ')</strong></p>';
    }

    // Cerramos la consulta preparada
    mysqli_stmt_close($stmt);

    // Mostrando la respuesta en formato JSON
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsonData);
}
?>

