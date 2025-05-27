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
					<a href="reportes.php"class="bxs-dashboard">
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
								<h1 class="card-title"><center><strong>CREAR USUARIO</strong></center></h1>
							</div>
							<div class="card-content">
							<div class="container mt-5">
								<form  enctype="multipart/form-data">
									<div class="form-group">
										<label for="nombre">Nombre:</label>
										<input type="text" class="form-control" name="nombre" id="nombre" required autofocus>
									</div>
									<div class="form-group">
										<label for="documento">documento:</label>
										<input type="text" class="form-control" name="documento" onkeyup="validarMinimo_documento(8)"  placeholder="documento" id="documento" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0, 10).replace(/[^0-9]/g, ''); else this.value = this.value.replace(/[^0-9]/g, '');" required>
                                        <div id="respuesta"> </div>
									</div>
									<div class="form-group">
										<label for="email">correo:</label>
										<input type="email" class="form-control" name="email" placeholder="correo electronico" id="email" required>
                                        <div id="respuesta_correo"> </div>
									</div>
                                    <div class="form-group">
										<label for="usuario">usuario:</label>
										<input type="text" class="form-control" name="usuario" onkeyup="validarMinimo(5)" placeholder="usuario" id="usuario" required>
                                        <div id="respuesta_usuario"> </div>
									</div>

									<div class="form-group">
										<label for="password">contraseña:</label>
										<input type="password" class="form-control" name="pass" placeholder="contraseña" id="pass" required>
									</div>
									
									<button  onclick="crear_vendedor(event)"  type="button" class="btn btn-primary" value="Registrarse" id = "btnIniciar">Crear Usuario</button>
								</form>
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
	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/validar_datos.js"></script>
	<script src="js/crear_usuario.js"></script>
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
</body>
</html>