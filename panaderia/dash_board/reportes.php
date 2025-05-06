<!doctype html>
<html lang="en">
<head>
    <!-- Meta básicos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://i.postimg.cc/nrGQ8SSX/logo.png">

    <title>CMS Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <!-- Estilos para los contenedores de los charts -->
    <style>
      #mas_vendido,
      #ventas_semana {
        width: 100%;
        height: 500px;
      }
    </style>

    
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
					<a href="index.php" class="dashboard"><i class="material-icons">dashboard</i><span>Inicio</span></a>
				</li>
				<li class="dropdown">
					<a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
						<i class="material-icons">fact_check</i><span>Inventario</span></a>
					<ul class="collapse list-unstyled menu" id="homeSubmenu1">
						<li>
							<a href="listar_productos.php"><i class="material-icons">check</i>Productos</a>
						</li>
						<li>
							<a href="agregar_producto.php"><i class="material-icons">add</i>Agregar</a>
						</li>
					</ul>
				</li>
				<!--<li class="sidebar-list-item">
					<a href="#"class="bxs-dashboard">
					<i class="material-icons">add_shopping_cart</i><span> Ordenes</span></a>
				</li>-->
				<li class="sidebar-list-item">
					<a href="buscar_ventas.php"class="bxs-dashboard">
					<i class="material-icons">shopping_cart</i><span> Ventas</span></a>
				</li>
				<li class="sidebar-list-item">
					<a href="#"class="bxs-dashboard">
					<i class="material-icons">poll</i><span> Reportes</span></a>
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
				<li class="dropdown">
					<a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
						<i class="material-icons">apps</i><span>widgets</span></a>
					<ul class="collapse list-unstyled menu" id="pageSubmenu2">
						<li>
							<a href="#">Page 1</a>
						</li>
						<li>
							<a href="#">Page 2</a>
						</li>
						<li>
							<a href="#">Page 3</a>
						</li>
					</ul>
				</li>
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
									<li class="dropdown nav-item">
									<a href="../sesion/cerrar.php"><i class="material-icons">logout</i></a>
								</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="main-content">
            <div class="row ">
					<div class="col-lg-6 col-md-12">
						<div class="card" style="min-height: 485px">
							<div class="card-content">
                            <h4 class="card-title">numero de ventas por dia</h4>
                            <div id="ventas_semana"></div>

							</div>
						</div>
					</div>



					<div class="col-lg-6 col-md-12">
						<div class="card" style="min-height: 485px">
							<div class="card-content">
							<h4 class="card-title">Top 5 productos mas vendidos</h4>
								<div  id="mas_vendido"></div>
							</div>
						</div>
					</div>

				</div>
            </div>
        </div>
	</div>
            </div>
        </div>
	</div>
   <!-- Optional JavaScript -->

<!-- amCharts 5 (core primero, luego módulos, luego tema) -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>




<!-- jQuery (versión completa) -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/reportes.js"></script>

<script>
  $(document).ready(function () {
    // Toggle del sidebar
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar, #content').toggleClass('active');
    });

    // Mostrar/ocultar menú en pantallas pequeñas
    $('.more-button, .body-overlay').on('click', function () {
      $('#sidebar, .body-overlay').toggleClass('show-nav');
    });
  });
</script>

	<center><?php include('../mostrar/includes/footer.html') ?></center>
</body>
</html>