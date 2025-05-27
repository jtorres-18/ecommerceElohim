<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];

    // Verificando si existe algún producto en la base de datos con dicho código asignado
    // Preparamos un arreglo que contendrá toda la información
    $jsonData = array();
    
    // Utilizamos una consulta preparada para evitar inyecciones SQL
    $selectQuery = "SELECT codigo FROM products WHERE codigo = ?";
    
    // Preparamos la consulta
    $stmt = mysqli_prepare($con, $selectQuery);

    // Vinculamos los parámetros
    mysqli_stmt_bind_param($stmt, "s", $codigo);

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
        $jsonData['message'] = '<p style="color:red;">Ya existe ese código <strong>(' . $codigo . ')<strong></p>';
        // Agregamos el código consultado al arreglo de respuesta
        $jsonData['codigo'] = $codigo;
    }

    // Cerramos la consulta preparada
    mysqli_stmt_close($stmt);

    // Mostrando la respuesta en formato JSON
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsonData);
}
?>
