<?php
session_start();
if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']);
}
?>



<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<link rel="website icon" type="png" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
	<title>cms dashboard
	</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<!----css3---->
	<link rel="stylesheet" href="css/custom.css">
	<!-- SweetAlert -->
	<!-- SweetAlert desde jsDelivr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

	<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!--google material icon-->
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<div class="wrapper">
		<div class="body-overlay"></div>
		<!-- Sidebar  -->
		<nav id="sidebar" class="active">
			<div class="sidebar-header">
				<h3><img src="https://i.postimg.cc/nrGQ8SSX/logo.png" class="img-fluid" /><span>ELOHIM</span></h3>
			</div>
			<ul class="list-unstyled components">
				<li class="active">
					<a href="index_vendor.php" class="dashboard"><i class="material-icons">dashboard</i><span>Inicio</span></a>
				</li>
				<li class="dropdown">
					<a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
						<i class="material-icons">fact_check</i><span>Inventario</span></a>
					<ul class="collapse list-unstyled menu" id="homeSubmenu1">
                    <li>
							<a href="realizar_ventaVen.php">realizar ventas</a>
						</li>
						<li>
							<a href="pedidos_online.php">pedidos online</a>
						</li>
					</ul>
				</li>
				<div class="small-screen navbar-display">
					<li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
						<a href="#homeSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
							<i class="material-icons">notifications</i><span> 4 notification</span></a>
						<ul class="collapse list-unstyled menu" id="homeSubmenu0">
							<li>
								<a href="#">You have 5 new messages</a>
							</li>
							<li>
								<a href="#">tonot</a>
							</li>
							<li>
								<a href="#">Wish Mary on her birthday!</a>
							</li>
							<li>
								<a href="#">5 warnings in Server Console</a>
							</li>
						</ul>
					</li>
				</div>
				
				<li class="d-lg-none d-md-block d-xl-none d-sm-block">
					<a href="#"><i class="material-icons">logout</i><span>Cerrar Sesion</span></a>
				</li>
			</ul>
		</nav>
		<!-- Page Content  -->
		<div id="content" class="active">
			<div class="top-navbar">
				<nav class="navbar navbar-expand-lg">
					<div class="container-fluid">
						<button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
							<span class="material-icons">list</span>
						</button>
						<button class="d-inline-block d-lg-none ml-auto more-button" type="button"
							data-toggle="collapse" data-target="#navbarSupportedContent"
							aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="material-icons">more_vert</span>
						</button>
						<div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none"
							id="navbarSupportedContent">
							<ul class="nav navbar-nav ml-auto">
								<li class="dropdown nav-item active">
									<a href="#" class="nav-link" data-toggle="dropdown">
										<span class="material-icons">notifications</span>
										<span class="notification">4</span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="#">You have 5 new messages</a>
										</li>
										<li>
											<a href="#">You're now friend with Mike</a>
										</li>
										<li>
											<a href="#">Wish Mary on her birthday!</a>
										</li>
										<li>
											<a href="#">5 warnings in Server Console</a>
										</li>
									</ul>
								</li>
                                <li class="dropdown nav-item">
									<a href="#" class="nav-link" data-toggle="dropdown">
										<span class="material-icons">logout</span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="#">Cerrar sesion</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="main-content">
				<div class="row">
				</div>
					<div class="col-12">
						<div class="card" style="min-height: 485px">
							<div class="card-header card-header-text">
							<h1 class="card-title text-center"><strong>VENTAS ONLINE</strong></h1>
<hr>
<h4>Pedidos:</h4>

<!-- Filtro -->
<div class="form-group mb-4">
	
  <div class="row g-2">
    
  <!-- Buscar por número de factura -->
    <div class="col-md-5">
      <label for="filtro_factura"><strong>Buscar por Número de Factura:</strong></label>
      <input type="text" id="filtro_factura" class="form-control form-control-sm" placeholder="Ej: 1746914980450" oninput="filtrarPorEstado()">
    </div>

    <!-- Filtrar por estado -->
    <div class="col-md-4">
      <label for="filtro_estado"><strong>Filtrar por Estado:</strong></label>
      <select id="filtro_estado" class="form-control form-control-sm" onchange="filtrarPorEstado()">
        <!-- Se llenará desde JS -->
      </select>
    </div>

    <!-- Botón limpiar -->
    <div class="col-md-3 d-flex align-items-end">
      <button class="btn btn-success btn-sm w-100" onclick="limpiarFiltros()">Limpiar</button>
    </div>
	
  </div>
</div>


<!-- Tabla de pedidos -->
<table class="table table-bordered">
  <thead>
    <tr>
		<th>Factura</th>
		<th>Dirección</th>
		<th>Fecha</th>
		<th>Método de pago</th>
		<th>Subtotal</th>
		<th>Estado</th>
		<th>Acción</th>
		<th>Detalles</th>
    </tr>
  </thead>
  <tbody id="tablaVentasPendientes"></tbody>
</table>

							</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
	</div>
    <!-- Optional JavaScript -->
	

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/ventas_online.js"></script>
	<script src="js/Ver_detalles.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
		$(document).ready(function () {
			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
				$('#content').toggleClass('active');
			});

			$('.more-button,.body-overlay').on('click', function () {
				$('#sidebar,.body-overlay').toggleClass('show-nav');
			});

		});
    </script>
	<center><?php include('../mostrar/includes/footer.html') ?></center>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<div class="modal fade" id="detallePedidoVendedorModal" tabindex="-1">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detalle del pedido</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<!-- Aquí se inyectará el contenido -->
			</div>
			</div>
		</div>
	</div>
</body>
</html>
