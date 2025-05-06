<?php
include('../mostrar/config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporte = $_POST['reporte'];
    if ($reporte == "producto") {
        try {
            $sql = "SELECT pr.nameProd, SUM(cantidad) as total_vendido
            FROM detalles_ventas dv
            INNER JOIN products pr
            ON pr.id=dv.id_producto
            GROUP BY id_producto
            ORDER BY total_vendido DESC
            LIMIT 5;
            ";
            // Ejecutar la consulta
            $result = $con->query($sql);
            // Verificar si la consulta fue exitosa
            if ($result) {
                // Obtener el resultado como un array asociativo
                $productos = [];
                while ($row = $result->fetch_assoc()) {
                    $productos[] = $row;
                }
                // Devolver el resultado como JSON
                echo json_encode($productos);
            } else {
                // Error en la consulta
                echo "2";
            }
        } catch (Exception $e) {
            // Manejar excepciones
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        } finally {
            // Cerrar la conexión mysqli correctamente
            $con->close();
        }
    }else{
        try {
            $sql = "SELECT dias_semana.dia, COALESCE(COUNT(ventas.total_venta), 0) as total_vendido_dia
            FROM (
                SELECT 'Monday' as dia
                UNION SELECT 'Tuesday'
                UNION SELECT 'Wednesday'
                UNION SELECT 'Thursday'
                UNION SELECT 'Friday'
                UNION SELECT 'Saturday'
                UNION SELECT 'Sunday'
            ) as dias_semana
            LEFT JOIN ventas ON dias_semana.dia = ventas.dia
            GROUP BY dias_semana.dia
            ORDER BY
                CASE
                    WHEN dias_semana.dia = 'Monday' THEN 1
                    WHEN dias_semana.dia = 'Tuesday' THEN 2
                    WHEN dias_semana.dia = 'Wednesday' THEN 3
                    WHEN dias_semana.dia = 'Thursday' THEN 4
                    WHEN dias_semana.dia = 'Friday' THEN 5
                    WHEN dias_semana.dia = 'Saturday' THEN 6
                    WHEN dias_semana.dia = 'Sunday' THEN 7
                END;
            
            ";
            // Ejecutar la consulta
            $result = $con->query($sql);
            // Verificar si la consulta fue exitosa
            if ($result) {
                // Obtener el resultado como un array asociativo
                $ventas = [];
                while ($row = $result->fetch_assoc()) {
                    $ventas[] = $row;
                }
                // Devolver el resultado como JSON
                echo json_encode($ventas);
            } else {
                // Error en la consulta
                echo "2";
            }
        } catch (Exception $e) {
            // Manejar excepciones
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        } finally {
            // Cerrar la conexión mysqli correctamente
            $con->close();
        }
    }
}
?>
