<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "gelohimg_elohim";
$user = "root";
$pass = "";

try {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        throw new Exception("No se pudo leer el cuerpo de la petición.");
    }
    
    $productos = $input['productos'] ?? null;
    $pago = $input['pago'] ?? null;

    if (!$productos || !is_array($productos) || count($productos) == 0) {
        throw new Exception("El campo 'productos' es obligatorio y debe ser un arreglo válido.");
    }

    if (!$pago) {
        throw new Exception("El campo 'pago' es obligatorio.");
    }

    // ✅ Métodos de pago válidos (enum simulado)
    $metodos_validos = ["tarjeta", "transferencia", "efectivo"];
    if (!in_array(strtolower($pago), $metodos_validos)) {
        throw new Exception("Método de pago inválido. Métodos válidos: tarjeta, transferencia, efectivo.");
    }

    $cliente = $input['cliente'] ?? null;
    if (!$cliente) {
        throw new Exception("Debes inciar sesion para realizar una compra.");
    }

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Datos globales
    $direccion = "LOCAL";
    $idVendedor = 0;
    $estado = 1; // pendiente
    $tipoVenta = 3;

    // Generar número de factura
    function generarNumeroFactura() {
        return round(microtime(true) * 1000) + rand(0, 999);
    }
    $numeroFactura = generarNumeroFactura();

    date_default_timezone_set('America/Bogota');
    $fechaHora = date("Y-m-d H:i:s");

    $totalVenta = 0;
    $insertados = [];
    $no_encontrados = [];

    foreach ($productos as $item) {
        if (!isset($item['id']) || !isset($item['cantidad'])) continue;

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$item['id']]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            $precioUnitario = $producto['precio'];
            $cantidad = $item['cantidad'];
            $subtotal = $precioUnitario * $cantidad;
            $totalVenta += $subtotal;
            $insertados[] = $item;
        } else {
            $no_encontrados[] = $item['id'];
        }
    }

    // ✅ Mensaje si hay productos no encontrados
    if (!empty($no_encontrados)) {
        throw new Exception("Los siguientes productos no existen: " . implode(", ", $no_encontrados));
    }

    if (count($insertados) > 0) {
        // Registrar venta
        $stmtVenta = $conn->prepare("
            INSERT INTO ventas (factura, total_venta, direccion, fecha_hora, metodo_pago, id_cliente, id_vendedor, id_estado, id_tipoVenta)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtVenta->execute([
            $numeroFactura,
            $totalVenta,
            $direccion,
            $fechaHora,
            $pago,
            $cliente,
            $idVendedor,
            $estado,
            $tipoVenta
        ]);
        $idVenta = $conn->lastInsertId();

        // Registrar detalles
        $stmtDetalle = $conn->prepare("
            INSERT INTO detalles_ventas (id_producto, cantidad, id_venta, subTotal)
            VALUES (?, ?, ?, ?)
        ");
        foreach ($insertados as $item) {
            $precio = $conn->query("SELECT precio FROM products WHERE id = {$item['id']}")->fetchColumn();
            $subtotal = $precio * $item['cantidad'];
            $stmtDetalle->execute([$item['id'], $item['cantidad'], $idVenta, $subtotal]);
        }

        echo json_encode([
            "success" => true,
            "factura" => $numeroFactura,
            "estado" => "pendiente",
            "mensaje" => "La venta ha sido registrada exitosamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "No se pudo registrar la venta. Ningún producto válido."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "mensaje" => $e->getMessage()
    ]);
}