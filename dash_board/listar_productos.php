<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="website icon" type="png" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
	<title>cms dashboard</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!----css3---->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<link rel="stylesheet" href="css/custom.css">
	<script src="js/editar_elimar.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!--google material icon-->
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <style>
		
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
        }

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
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
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
									<a href="../sesion/cerrar.php"><i class="material-icons">logout</i></a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="table-container">
                <div class="row">
					<div class="col-12">
						<!-- Div para la lista de productos -->
						<div class="card" style="min-height: 485px">
							<div class="card-header card-header-text">
								<h4 class="card-title"><center><strong> LISTA DE PRODUCTOS</strong></center></h4>
								
							</div>
							<div class="card-content">
							<?php
include("../mostrar/config/config.php");

// 1) Ejecutar la consulta y controlar errores
$query = "
    SELECT 
      p.id, 
      p.codigo, 
      p.nameProd, 
      p.precio, 
      p.description_Prod, 
      p.estado, 
      fp.foto1
    FROM products p
    JOIN fotoproducts fp 
      ON p.id = fp.products_id
";
$result = $con->query($query);
if ($result === false) {
    die("Error en la consulta: " . $con->error);
}

// 2) Mostrar tabla sólo si hay resultados
if ($result->num_rows > 0) {
    echo '
    <table class="table table-responsive-sm table-responsive-md table-hover table-bordered">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre del Producto</th>
          <th>Precio</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Foto</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
    ';

    while ($row = $result->fetch_assoc()) {
        // 3) Interpretar estado
        $estado = ($row["estado"] == 1) ? "Activo" : "Desactivado";

        // 4) Ruta segura de la imagen
        $imagePath = "../dash_board/img/" . htmlspecialchars($row["foto1"], ENT_QUOTES, 'UTF-8');

        echo '<tr>';
            echo '<td>' . htmlspecialchars($row["codigo"], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($row["nameProd"], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>$ ' . number_format($row["precio"], 0, '', '.') . '</td>';
            echo '<td>' . htmlspecialchars($row["description_Prod"], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . $estado . '</td>';
            echo '<td><center><img src="' . $imagePath . '" alt="Foto del producto" style="max-width:100px; max-height:100px;"></center></td>';
            echo '<td>
                    <center>
                      <button 
                        onclick="datos_producto(\'' . $row["id"] . '\')" 
                        type="button" 
                        class="btn btn-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal"
                      >
                        <i class="material-icons">edit</i>
                      </button>
                    </center>
                    <center style="margin-top:10px;">
                      <button 
                        type="button" 
                        class="btn btn-danger" 
                        onclick="eliminarProducto(\'' . $row["id"] . '\')"
                      >
                        <i class="material-icons">delete</i>
                      </button>
                    </center>
                  </td>';
        echo '</tr>';
    }

    echo '
      </tbody>
    </table>
    ';
} else {
    echo '<p>No se encontraron resultados.</p>';
}

$con->close();
?>


							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<!-- Div para las fotos de productos -->
						<!--<div class="card" style="min-height: 485px">
							<div class="card-header card-header-text">
                            <h4 class="card-title"><center><strong>FOTOS DEL PRODUCTOS</strong></center></h4>
							</div>
						</div>-->
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
	




<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">editar producto</h5>
      </div>
      <div class="modal-body">
	  <form action="procesar_producto.php" method="post" enctype="multipart/form-data" id="productoForm">
                        <div class="form-group">
                            <label for="codigo">Código del Producto:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" required>
							<input type="hidden" class="form-control" name="codigo" id="codigo2" required>
                            <div id="respuesta"> </div>
                        </div>
                        <div class="form-group">
                            <label for="nameProd">Nombre del Producto:</label>
                            <input type="text" class="form-control" name="nameProd" id="nameProd" required>
                            <div id="respuesta2"> </div>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" class="form-control" name="precio" id="precio" required>
                        </div>
                        <div class="form-group">
                            <label for="description_Prod">Descripción del Producto:</label>
                            <textarea class="form-control" name="description_Prod" id="descripcion" rows="3"></textarea>
                        </div>
						<div class="form-group">
                                    <label for="categoria" class="col-form-label">categoria:</label>
                                            <select class="form-select" aria-label="Default select example" id="categoria">
                                            <option value="Panaderia">Panaderia</option>
                                            <option value="eposteria">Reposteria</option>
                                            </select>
                                        </div>
						<div class="form-group">
                                    <label for="estado" class="col-form-label">estado:</label>
                                            <select class="form-select" aria-label="Default select example" id="estado">
                                            <option value="activo">activo</option>
                                            <option value="desactivo">desactivo</option>
                                            </select>
                                        </div>
                        <div class="form-group">
                            <label for="foto1">Foto 1:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="foto1" accept="image/*" required>
                                <label class="custom-file-label" for="customFile">Seleccionar archivo</label>
                            </div>
                        </div>
						<input type="hidden" id="id" required>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btonAgg" onclick="editarProducto(event)" type="button" class="btn btn-primary">guardar</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
