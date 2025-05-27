<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION['entro']) && $_SESSION['entro']==true ){
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<link rel="website icon" type="png" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
	<title>VENDEDOR PANEL</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!----css3---->
	<link rel="stylesheet" href="css/custom.css">
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
					<a href="../sesion/cerrar.php"><i class="material-icons">logout</i><span>Cerrar Sesion</span></a>
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
									<a href="../sesion/cerrar.php"><i class="material-icons">logout</i></a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="main-content">
				<div class="row">
					
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="card card-stats">
							<div class="card-header">
								<div class="icon icon-rose">
									<span class="material-icons">shopping_cart</span>

								</div>
							</div>
							<div class="card-content">
								<p class="category"><strong>Orders</strong></p>
								<h3 class="card-title">102</h3>
							</div>
							<div class="card-footer">
								<div class="stats">
									<i class="material-icons">local_offer</i> Product-wise sales
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="card card-stats">
							<div class="card-header">
								<div class="icon icon-success">
									<span class="material-icons">
										attach_money
									</span>

								</div>
							</div>
							<div class="card-content">
								<p class="category"><strong>Ganacias</strong></p>
								<h3 class="card-title">$2310</h3>
							</div>
							<div class="card-footer">
								<div class="stats">
									<i class="material-icons">date_range</i> Ventas Semanales
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="card card-stats">
							<div class="card-header">
								<div class="icon icon-info">
									<span class="material-icons">
										follow_the_signs
									</span>
								</div>
							</div>
							<div class="card-content">
								<p class="category"><strong>Followers</strong></p>
								<h3 class="card-title">+245</h3>
							</div>
							<div class="card-footer">
								<div class="stats">
									<i class="material-icons">update</i> Just Updated
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row ">
					<div class="col-lg-7 col-md-12">
						<div class="card" style="min-height: 485px">
							<div class="card-header card-header-text">
								<h4 class="card-title">Ultimos pedidos</h4>
								<p class="category">Ultimos pedidos | <span id="currentDate"></span>
								</p>
								<script>
									const date = new Date();
									const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
									const currentDate = date.toLocaleDateString('es-ES', options);
		
									document.getElementById("currentDate").innerText = currentDate;
								</script>
							</div>
							<div class="card-content table-responsive">
								<table class="table table-hover">
									<thead class="text-primary">
										<tr>
											<th>FACTURA</th>
											<th>NOMBRE</th>
											<th>VALOR TOTAL</th>
											<th>METODO PAGO</th>
										</tr>
									</thead>
									<?php
									include("../mostrar/config/config.php");
									$sql = "SELECT v.factura, v.total_venta, v.metodo_pago, v.id_cliente, us.nombre
											FROM ventas v
											JOIN usuarios us ON v.id_cliente = us.id
											LIMIT 5";
									$result = $con->query($sql);
									if ($result->num_rows > 0) {
										while($row = $result->fetch_assoc()) {
											echo "<tr>
													<td>" . $row["factura"]. "</td>
													<td>" . $row["nombre"]. "</td>
													<td>" . $row["total_venta"]. "</td>
													<td>" . $row["metodo_pago"]. "</td>
												</tr>";
										}
									} else {
										echo "<tr><td colspan='4'>0 resultados</td></tr>";
									}
									echo "</tbody></table>";
									// Cerrar conexión
									$con->close();
									?>
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-md-12">
						<div class="card" style="min-height: 485px">
							<div class="card-header card-header-text">
								<h4 class="card-title">Activities</h4>
							</div>
							<div class="card-content">
								<div class="streamline">
									<div class="sl-item sl-primary">
										<div class="sl-content">
											<small class="text-muted">5 mins ago</small>
											<p>Williams has just joined Project X</p>
										</div>
									</div>
									<div class="sl-item sl-danger">
										<div class="sl-content">
											<small class="text-muted">25 mins ago</small>
											<p>Jane has sent a request for access to the project folder</p>
										</div>
									</div>
									<div class="sl-item sl-success">
										<div class="sl-content">
											<small class="text-muted">40 mins ago</small>
											<p>Kate added you to her team</p>
										</div>
									</div>
									<div class="sl-item">
										<div class="sl-content">
											<small class="text-muted">45 minutes ago</small>
											<p>John has finished his task</p>
										</div>
									</div>
									<div class="sl-item sl-warning">
										<div class="sl-content">
											<small class="text-muted">55 mins ago</small>
											<p>Jim shared a folder with you</p>
										</div>
									</div>
									<div class="sl-item">
										<div class="sl-content">
											<small class="text-muted">60 minutes ago</small>
											<p>John has finished his task</p>
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
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
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
</body>
</html>
<?php
	}else{
?>
		<script>  window.location.href = "../sesion/login.html" ; </script>
		<?php
	}
?>