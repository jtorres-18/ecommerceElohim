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
	<!----css3---->
	<link rel="stylesheet" href="css/custom.css">
	<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!--google material icon-->
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <style>
        .table-container {
            width: 80%;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
					<ul class="collapse list-unstyled menu" id="pageSubmenu2">
						<li>
						<a href="crear_usuario.php">crear usario</a>
						</li>
						<li>
							<a href="#">Page 2</a>
						</li>
						<li>
							<a href="#">Page 3</a>
						</li>
					</ul>
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
                            <h1 class="card-title"><center><strong> DETALLES VENTA</strong></center></h1>
							</div>
							<div class="card-content">
                                <table class="table" id="salesTable">
                                    <tbody>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="searchQuery">Buscar por factura o código de producto:</label>
                                            <input type="text" id="searchQuery" name="searchQuery" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </form>
                                    <?php
                                    include("../mostrar/config/config.php");
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchQuery'])) {
                                        $searchQuery = $_POST['searchQuery'];
                                    
                                        $sql = "SELECT vt.factura, dv.cantidad, pd.codigo, pd.nameProd, pd.precio, vt.total_venta, vt.metodo_pago, vt.fecha_hora
                                                FROM detalles_ventas dv
                                                INNER JOIN products pd ON dv.id_producto = pd.id
                                                INNER JOIN ventas vt ON dv.id_venta = vt.id
                                                WHERE factura LIKE '%$searchQuery%' OR codigo LIKE '%$searchQuery%'
                                                ORDER BY factura, fecha_hora DESC;";
                                        // Ejecutar la consulta personalizada
                                        $result = $con->query($sql);
                                        $prevFactura = null; // Variable para rastrear la factura anterior
                                        if ($result->num_rows > 0) {
                                            // Mostrar los datos de la consulta en una tabla
                                            echo "<table class='table table-striped table-responsive-sm table-responsive-md table-hover table-bordered'>
                                                    <thead>
                                                        <tr>
                                                            <th>Factura</th>
                                                            <th>Cantidad</th>
                                                            <th>Código</th>
                                                            <th>Nombre del Producto</th>
                                                            <th>Precio</th>
                                                            <th>Total Venta</th>
                                                            <th>Método de Pago</th>
                                                            <th>Fecha y Hora</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                            while ($row = $result->fetch_assoc()) {
                                                if ($row["factura"] !== $prevFactura) {
                                                    // Imprimir solo si la factura es diferente a la anterior
                                                    echo "<tr>
                                                            <td>" . $row["factura"] . "</td>
                                                            <td>" . $row["cantidad"] . "</td>
                                                            <td>" . $row["codigo"] . "</td>
                                                            <td>" . $row["nameProd"] . "</td>
                                                            <td>" . $row["precio"] . "</td>
                                                            <td>" . $row["total_venta"] . "</td>
                                                            <td>" . $row["metodo_pago"] . "</td>
                                                            <td>" . $row["fecha_hora"] . "</td>
                                                        </tr>";
                                                    // Actualizar la factura anterior
                                                    $prevFactura = $row["factura"];
                                                } else {
                                                    // Imprimir solo las filas adicionales si la factura es la misma
                                                    echo "<tr>
                                                            <td></td>
                                                            <td>" . $row["cantidad"] . "</td>
                                                            <td>" . $row["codigo"] . "</td>
                                                            <td>" . $row["nameProd"] . "</td>
                                                            <td>" . $row["precio"] . "</td>
                                                            <td>" . $row["total_venta"] . "</td>
                                                            <td>" . $row["metodo_pago"] . "</td>
                                                            <td>" . $row["fecha_hora"] . "</td>
                                                        </tr>";
                                                }
                                            }
                                            echo "</tbody></table>";
                                        } else {
                                            echo "No se encontraron resultados.";
                                        }
                                        $con->close();
                                    }
                                    ?>
                                </table>
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