<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $new_codigo = $_POST['new_codigo'];
    $nameProd = $_POST['nameProd'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST["categoria"];
    $estado = $_POST["estado"];
    $stmtGetId = null;
    try {

            // Actualizar la tabla 'products'
            $sqlUpdateProducts = "UPDATE products SET codigo = ?, nameProd = ?, precio = ?, description_Prod = ?, categoria = ?, estado = ? WHERE id = ?";
            $stmtUpdateProducts = $con->prepare($sqlUpdateProducts);
            $stmtUpdateProducts->bind_param('ssdsiii', $new_codigo, $nameProd, $precio, $descripcion, $categoria, $estado, $id);
            $stmtUpdateProducts->execute();
            
            $uploadDir = "../dash_board/img/";

            // Antes de mover la nueva imagen, elimina la imagen anterior
            $sqlFoto = "SELECT foto1 FROM fotoproducts WHERE products_id = ?";
            $stmtFoto = $con->prepare($sqlFoto);
            $stmtFoto->bind_param('i', $id);
            $stmtFoto->execute();
            $stmtFoto->store_result();
            $stmtFoto->bind_result($nombre_foto);
            $stmtFoto->fetch();

        if (isset($_FILES['foto1'])) {
        // Verificar si no hay errores en la carga del archivo
        if ($_FILES['foto1']['error'] === 0) {
            // El archivo se cargó con éxito
            $foto1 = $_FILES['foto1']['name'];

                if (file_exists($uploadDir . $nombre_foto)) {
                    unlink($uploadDir . $nombre_foto);
                }
                // Mueve la nueva imagen
                move_uploaded_file($_FILES["foto1"]["tmp_name"], $uploadDir . $foto1);
    
                // Actualiza la tabla 'fotoproducts'
                $sqlUpdatefotoProducts = "UPDATE fotoproducts SET foto1 = ? WHERE products_id = ?";
                $stmtUpdatefotoProducts = $con->prepare($sqlUpdatefotoProducts);
                $stmtUpdatefotoProducts->bind_param('si', $foto1, $id);
                $stmtUpdatefotoProducts->execute();
            }
        }// Elimina la foto anterior
            

            echo "1"; // Éxito
        
    } catch (mysqli_exception $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    } finally {
        if ($stmtGetId !== null) {
            $stmtGetId->close();
        }
        $stmtUpdateProducts->close();
        $stmtFoto->close();
        $con->close();
    }
}
?>
