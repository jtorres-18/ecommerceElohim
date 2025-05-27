
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title> Panadería elohim</title>
</head>
<body>

<div class="contenedor-formulario contra">
    <div class="informacion"> 
        <div class="info-datos">
            <h2> Bienvenido nuevamente</h2>
        </div>
    </div>
    <div class="formulario-crear">
        <div class="formulario-crear-datos">
        <h2>recuperar contraseña </h2>
        <form  class="form" id="form-contra">
            <label >
                <i class='bx bx-lock-alt' ></i>
                <input type="password" name="pass" placeholder="nueva contraseña" id="passs" required>
            </label>
            <label>
                <i class='bx bx-lock-alt' ></i>
                <input type="password" name="pass" placeholder="confirmar contraseña" id="new_passs" required>
            </label>
            <div id="respuesta"> </div>
            <input type="hidden" id="id" value="<?php echo $_GET['id']?>">
            <input type="button" onclick=" nueva_contra(event)" value="ingresar" id="btn_ingresar">
        </form>
        </div>
    </div>
</div>
<script src="escrips.js"></script>
<script src="validar_formulario/validar_contra.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>



