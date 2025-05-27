<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../sesion/login.html');
    exit;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../sesion/login.html');
    exit;
}

require_once 'config/config.php';
require_once 'funciones/funciones_tienda.php';
require_once 'funciones/funciones_pedidos.php';

$usuario_id = $_SESSION['usuario_id'];

include 'header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de Compras - Elohim</title>
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/responsive.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/historial.css">
</head>

<body>
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div>
            <span>cargando...</span>
        </div>
    </div>

    <main class="main-content container mt-5">
  <h4>Pedidos:</h4>
  <div class="row mb-3">
    <div class="col-md-4">
      <label for="filtro_estado">Estado:</label>
      <select id="filtro_estado" class="form-control">
        <option value="todos">Todos</option>
        <option value="pendiente">Pendientes</option>
        <option value="aprobado">Aprobados</option>
        <option value="enviado">Enviados</option>
        <option value="entregado">Entregados</option>
        <option value="cancelado">Cancelados</option>
      </select>
    </div>
    <div class="col-md-4">
      <label for="filtro_periodo">Rango:</label>
      <select id="filtro_periodo" class="form-control">
        <option value="1s">Última semana</option>
        <option value="1m">Último mes</option>
        <option value="3m" selected>Últimos 3 meses</option>
      </select>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Factura</th><th>Fecha</th><th>Estado</th><th>Total</th><th>Acción</th>
      </tr>
    </thead>
    <tbody id="tablaHistorialPedidos"></tbody>
  </table>
</main>

<!-- Modal detalle de pedido -->
<!-- En tu historial-compras.php -->
<div class="modal fade" id="detallePedidoModal" tabindex="-1" aria-labelledby="detallePedidoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detallePedidoModalLabel">Detalle de la orden</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Cerrar">
          <i class="bi bi-x-lg"></i>
        </button>

      </div>
      <div class="modal-body">
        <!-- El contenido se cargará dinámicamente -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    <?php include('includes/footer.html'); ?>
    <?php include_once '../chatbot/index.php'; ?>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/styles/bootstrap4/popper.js"></script>
    <script src="assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="assets/js/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 2) Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <!-- 3) SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- 4) Tu JS que depende de todo lo anterior -->
    <script src="assets/js/historial_usuario.js"></script>

<script>
// Script para verificar que todo está cargado correctamente
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM cargado completamente');
  
  // Verificar que jQuery está disponible
  if (typeof $ !== 'undefined') {
    console.log('jQuery está disponible');
  } else {
    console.error('jQuery NO está disponible');
  }
  
  // Verificar que Bootstrap está disponible
  if (typeof bootstrap !== 'undefined') {
    console.log('Bootstrap está disponible');
  } else {
    console.error('Bootstrap NO está disponible');
  }
  
  // Verificar que SweetAlert2 está disponible
  if (typeof Swal !== 'undefined') {
    console.log('SweetAlert2 está disponible');
  } else {
    console.error('SweetAlert2 NO está disponible');
  }
  
  // Verificar que la función verDetalles está disponible
  if (typeof verDetalles === 'function') {
    console.log('Función verDetalles está disponible');
  } else {
    console.error('Función verDetalles NO está disponible');
  }
});
</script>
</body>
</html>
