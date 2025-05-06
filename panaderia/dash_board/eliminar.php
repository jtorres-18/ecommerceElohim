<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];

    try {
        // Obtener el ID del producto
        $sqlGetId = "SELECT id FROM products WHERE codigo = ?";
        $stmtGetId = $con->prepare($sqlGetId);
        $stmtGetId->bind_param('s', $codigo);
        $stmtGetId->execute();
        $stmtGetId->store_result();

        // Verificar si se encontró el producto
        if ($stmtGetId->num_rows > 0) {
            $stmtGetId->bind_result($productId);
            $stmtGetId->fetch();

            $sqlGetdetalle = "SELECT id FROM detalles_ventas WHERE id_producto = ?";
            $stmtGetdetalle = $con->prepare($sqlGetdetalle);
            $stmtGetdetalle->bind_param('i', $productId);
            $stmtGetdetalle->execute();
            $stmtGetdetalle->store_result();

        // Verificar si se encontró el producto
        if ($stmtGetdetalle->num_rows > 0) {
            echo"2";
        }else{
            $sqlnombreFoto = "SELECT foto1 FROM fotoproducts WHERE 	products_id = ?";
            $stmtnombreFoto = $con->prepare($sqlnombreFoto);
            $stmtnombreFoto->bind_param('s', $productId);
            $stmtnombreFoto->execute();
            $stmtnombreFoto->store_result();

        // Verificar si se encontró el producto
        
        $stmtnombreFoto->bind_result($foto);
        $stmtnombreFoto->fetch();
        $uploadDir = "../dash_board/img/";
        if (file_exists($uploadDir . $foto)) {
            unlink($uploadDir . $foto);
        }

            // Eliminar de la tabla fotoproducts
            $sqlDeleteFoto = "DELETE FROM fotoproducts WHERE products_id = ?";
            $stmtDeleteFoto = $con->prepare($sqlDeleteFoto);
            $stmtDeleteFoto->bind_param('i', $productId);
            $stmtDeleteFoto->execute();

            // Eliminar de la tabla products
            $sqlDeleteProduct = "DELETE FROM products WHERE id = ?";
            $stmtDeleteProduct = $con->prepare($sqlDeleteProduct);
            $stmtDeleteProduct->bind_param('i', $productId);
            $stmtDeleteProduct->execute();

            echo "1"; // Éxito
        }
            
        }
    } catch (mysqli_sql_exception $e) {
        echo "error al elimar";
    } finally {
        // Cerrar la conexión
        $con->close();
    }
}
?>
