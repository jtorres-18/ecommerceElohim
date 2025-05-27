<?php
session_start();
include 'config/config.php';
include 'header.php';

// Verificar si el usuario está logueado - Comprobamos diferentes variables de sesión que podrían contener el ID
$id_usuario = null;
if (isset($_SESSION['id_cliente'])) {
    $id_usuario = $_SESSION['id_cliente'];
} elseif (isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
} elseif (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} elseif (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];
}

// Si no hay sesión activa, redirigir al login
if (!$id_usuario) {
    // Añadimos un log para depuración
    error_log("No se encontró sesión de usuario activa en perfil.php. Variables de sesión: " . print_r($_SESSION, true));
    
    echo '<script>
        Swal.fire({
            icon: "warning",
            title: "Sesión no iniciada",
            text: "Debes iniciar sesión para acceder a tu perfil",
            confirmButtonColor: "#b98c62"
        }).then(() => {
            window.location.href = "../sesion/login.html";
        });
    </script>';
    exit;
}

// Obtener información del usuario
$conn = mysqli_connect($servidor, $usuario, $password, $basededatos);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Depuración - Mostrar el ID de usuario que estamos usando
error_log("ID de usuario utilizado en perfil.php: " . $id_usuario);

// Verificar qué tablas existen en la base de datos
$tablas_result = mysqli_query($conn, "SHOW TABLES");
$tablas = [];
while ($tabla = mysqli_fetch_array($tablas_result)) {
    $tablas[] = $tabla[0];
}
error_log("Tablas disponibles en la base de datos: " . implode(", ", $tablas));

// Verificar si la tabla 'usuarios' existe
if (in_array('usuarios', $tablas)) {
    // Verificar la estructura de la tabla usuarios
    $columnas_result = mysqli_query($conn, "DESCRIBE usuarios");
    $columnas = [];
    while ($columna = mysqli_fetch_array($columnas_result)) {
        $columnas[] = $columna[0];
    }
    error_log("Columnas en la tabla usuarios: " . implode(", ", $columnas));
    
    // Preparar la consulta con verificación de errores
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt === false) {
        error_log("Error en la preparación de la consulta: " . mysqli_error($conn));
        die("Error en la consulta: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($resultado) > 0) {
        $usuario_data = mysqli_fetch_assoc($resultado);
        error_log("Datos de usuario encontrados: " . print_r($usuario_data, true));
    } else {
        error_log("No se encontró ningún usuario con ID: " . $id_usuario);
        
        // Intentar buscar en otras tablas posibles
        $tablas_alternativas = ['clientes', 'users', 'user', 'cliente'];
        $usuario_encontrado = false;
        
        foreach ($tablas_alternativas as $tabla) {
            if (in_array($tabla, $tablas)) {
                error_log("Intentando buscar en la tabla alternativa: " . $tabla);
                
                // Verificar la estructura de la tabla alternativa
                $columnas_alt_result = mysqli_query($conn, "DESCRIBE $tabla");
                $columnas_alt = [];
                while ($columna = mysqli_fetch_array($columnas_alt_result)) {
                    $columnas_alt[] = $columna[0];
                }
                error_log("Columnas en la tabla $tabla: " . implode(", ", $columnas_alt));
                
                // Buscar el usuario en esta tabla alternativa
                $sql_alt = "SELECT * FROM $tabla WHERE id = ?";
                $stmt_alt = mysqli_prepare($conn, $sql_alt);
                
                if ($stmt_alt) {
                    mysqli_stmt_bind_param($stmt_alt, "i", $id_usuario);
                    mysqli_stmt_execute($stmt_alt);
                    $resultado_alt = mysqli_stmt_get_result($stmt_alt);
                    
                    if (mysqli_num_rows($resultado_alt) > 0) {
                        $usuario_data = mysqli_fetch_assoc($resultado_alt);
                        error_log("Usuario encontrado en tabla alternativa $tabla: " . print_r($usuario_data, true));
                        $usuario_encontrado = true;
                        break;
                    }
                }
            }
        }
        
        if (!$usuario_encontrado) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo encontrar la información del usuario",
                    confirmButtonColor: "#b98c62"
                }).then(() => {
                    window.location.href = "productos.php";
                });
            </script>';
            exit;
        }
    }
} else {
    // La tabla 'usuarios' no existe, buscar en tablas alternativas
    $tablas_alternativas = ['clientes', 'users', 'user', 'cliente'];
    $usuario_encontrado = false;
    
    foreach ($tablas_alternativas as $tabla) {
        if (in_array($tabla, $tablas)) {
            error_log("La tabla 'usuarios' no existe. Intentando con tabla alternativa: " . $tabla);
            
            // Verificar la estructura de la tabla alternativa
            $columnas_alt_result = mysqli_query($conn, "DESCRIBE $tabla");
            $columnas_alt = [];
            while ($columna = mysqli_fetch_array($columnas_alt_result)) {
                $columnas_alt[] = $columna[0];
            }
            error_log("Columnas en la tabla $tabla: " . implode(", ", $columnas_alt));
            
            // Buscar el usuario en esta tabla alternativa
            $sql_alt = "SELECT * FROM $tabla WHERE id = ?";
            $stmt_alt = mysqli_prepare($conn, $sql_alt);
            
            if ($stmt_alt) {
                mysqli_stmt_bind_param($stmt_alt, "i", $id_usuario);
                mysqli_stmt_execute($stmt_alt);
                $resultado_alt = mysqli_stmt_get_result($stmt_alt);
                
                if (mysqli_num_rows($resultado_alt) > 0) {
                    $usuario_data = mysqli_fetch_assoc($resultado_alt);
                    error_log("Usuario encontrado en tabla alternativa $tabla: " . print_r($usuario_data, true));
                    $usuario_encontrado = true;
                    break;
                }
            }
        }
    }
    
    if (!$usuario_encontrado) {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo encontrar la tabla de usuarios en la base de datos",
                confirmButtonColor: "#b98c62"
            }).then(() => {
                window.location.href = "productos.php";
            });
        </script>';
        exit;
    }
}

// Obtener historial de pedidos recientes (últimos 3)
// Primero verificar si la tabla ventas existe
if (in_array('ventas', $tablas)) {
    $sql_pedidos = "SELECT id, fecha, total, estado FROM ventas WHERE id_cliente = ? ORDER BY fecha DESC LIMIT 3";
    $stmt_pedidos = mysqli_prepare($conn, $sql_pedidos);
    
    if ($stmt_pedidos) {
        mysqli_stmt_bind_param($stmt_pedidos, "i", $id_usuario);
        mysqli_stmt_execute($stmt_pedidos);
        $resultado_pedidos = mysqli_stmt_get_result($stmt_pedidos);
    } else {
        error_log("Error en la consulta de pedidos: " . mysqli_error($conn));
        $resultado_pedidos = false;
    }
} else {
    error_log("La tabla 'ventas' no existe en la base de datos");
    $resultado_pedidos = false;
}

mysqli_close($conn);

// Determinar el nombre y correo del usuario
$nombre_usuario = isset($usuario_data['nombre']) ? $usuario_data['nombre'] : (isset($usuario_data['name']) ? $usuario_data['name'] : 'Usuario');
$correo_usuario = isset($usuario_data['correo']) ? $usuario_data['correo'] : (isset($usuario_data['email']) ? $usuario_data['email'] : 'correo@ejemplo.com');
$documento_usuario = isset($usuario_data['documento']) ? $usuario_data['documento'] : (isset($usuario_data['document']) ? $usuario_data['document'] : '');
$telefono_usuario = isset($usuario_data['telefono']) ? $usuario_data['telefono'] : (isset($usuario_data['phone']) ? $usuario_data['phone'] : '');

// Obtener la primera letra del nombre para el avatar
$primera_letra = strtoupper(substr($nombre_usuario, 0, 1));
?>

<!-- Añadimos un script para depuración en el navegador -->
<script>
    console.log("Sesión actual:", <?php echo json_encode($_SESSION); ?>);
    console.log("ID de usuario:", <?php echo json_encode($id_usuario); ?>);
    console.log("Datos de usuario:", <?php echo json_encode(isset($usuario_data) ? $usuario_data : null); ?>);
</script>

<!-- Incluir estilos del header y footer existentes -->
<link rel="stylesheet" href="assets/styles/bootstrap4/bootstrap.min.css">
<link rel="stylesheet" href="assets/styles/main_styles.css">
<link rel="stylesheet" href="assets/styles/header.css">
<link rel="stylesheet" href="assets/styles/footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Estilos específicos para la página de perfil -->
<style>
    /* Variables CSS específicas para el perfil */
    .perfil-page {
        --perfil-primary-color: #e3a04b;
        --perfil-primary-dark: #c78c3c;
        --perfil-primary-light: #f5d6a8;
        --perfil-secondary-color: #8b572a;
        --perfil-accent-color: #e94e1b;
        --perfil-text-color: #333333;
        --perfil-text-light: #666666;
        --perfil-text-lighter: #888888;
        --perfil-bg-color: #f8f9fa;
        --perfil-bg-light: #ffffff;
        --perfil-border-color: #e9ecef;
        --perfil-border-radius: 12px;
        --perfil-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    /* Contenedor principal del perfil */
    .perfil-page {
        background-color: var(--perfil-bg-color);
        color: var(--perfil-text-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .perfil-container {
    margin-top: 60px !important; /* Reducido de 120px */
    padding-bottom: 30px; /* Reducido de 60px */
    }      
    
    .perfil-card {
        background-color: var(--perfil-bg-light);
        border-radius: var(--perfil-border-radius);
        box-shadow: var(--perfil-shadow);
        padding: 40px;
        margin-bottom: 30px;
        border: none;
    }
    
    .perfil-header {
        margin-bottom: 30px;
    }
    
    .perfil-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--perfil-text-color);
    }
    
    .perfil-info {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .perfil-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 30px;
        background-color: var(--perfil-primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        font-weight: 500;
    }
    
    .perfil-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .perfil-details {
        flex: 1;
    }
    
    .perfil-name {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--perfil-text-color);
    }
    
    .perfil-email {
        font-size: 18px;
        color: var(--perfil-text-light);
        margin-bottom: 15px;
    }
    
    .btn-edit-profile {
        background-color: transparent;
        border: 1px solid var(--perfil-border-color);
        color: var(--perfil-text-color);
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-edit-profile:hover {
        background-color: var(--perfil-primary-color);
        border-color: var(--perfil-primary-color);
        color: white;
    }
    
    .perfil-data {
        margin-bottom: 30px;
    }
    
    .perfil-data-row {
        display: flex;
        margin-bottom: 15px;
    }
    
    .perfil-data-label {
        width: 200px;
        font-weight: 500;
        color: var(--perfil-text-light);
    }
    
    .perfil-data-value {
        flex: 1;
        color: var(--perfil-text-color);
    }
    
    .perfil-tabs {
        display: flex;
        border-bottom: 1px solid var(--perfil-border-color);
        margin-bottom: 30px;
    }
    
    .perfil-tab {
        padding: 15px 20px;
        font-weight: 500;
        color: var(--perfil-text-light);
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .perfil-tab.active {
        color: var(--perfil-primary-color);
        border-bottom-color: var(--perfil-primary-color);
    }
    
    .perfil-tab:hover {
        color: var(--perfil-primary-color);
    }
    
    .perfil-tab-content {
        display: none;
    }
    
    .perfil-tab-content.active {
        display: block;
    }
    
    .perfil-form-group {
        margin-bottom: 20px;
    }
    
    .perfil-form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--perfil-text-light);
    }
    
    .perfil-form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--perfil-border-color);
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .perfil-form-control:focus {
        border-color: var(--perfil-primary-color);
        box-shadow: 0 0 0 3px rgba(227, 160, 75, 0.2);
        outline: none;
    }
    
    .perfil-btn-primary {
        background-color: var(--perfil-primary-color);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .perfil-btn-primary:hover {
        background-color: var(--perfil-primary-dark);
    }
    
    .perfil-btn-outline {
        background-color: transparent;
        border: 1px solid var(--perfil-border-color);
        color: var(--perfil-text-color);
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 10px;
    }
    
    .perfil-btn-outline:hover {
        background-color: var(--perfil-border-color);
    }
    
    .perfil-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .perfil-table th {
        text-align: left;
        padding: 12px 15px;
        border-bottom: 1px solid var(--perfil-border-color);
        color: var(--perfil-text-light);
        font-weight: 500;
    }
    
    .perfil-table td {
        padding: 15px;
        border-bottom: 1px solid var(--perfil-border-color);
    }
    
    .perfil-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .perfil-badge-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .perfil-badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .perfil-badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .perfil-empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    
    .perfil-empty-state-icon {
        font-size: 48px;
        color: var(--perfil-text-lighter);
        margin-bottom: 15px;
    }
    
    .perfil-empty-state-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--perfil-text-color);
    }
    
    .perfil-empty-state-text {
        color: var(--perfil-text-light);
        margin-bottom: 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .perfil-container {
            margin-top: 80px !important;
        }
        
        .perfil-card {
            padding: 20px;
        }
        
        .perfil-info {
            flex-direction: column;
            text-align: center;
        }
        
        .perfil-avatar {
            margin-right: 0;
            margin-bottom: 20px;
        }
        
        .perfil-data-row {
            flex-direction: column;
        }
        
        .perfil-data-label {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .perfil-tabs {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

<div class="perfil-page">
    <div class="container perfil-container">
        <div class="perfil-card">
            <div class="perfil-header">
                <h1>Mi perfil</h1>
            </div>
            
            <div class="perfil-info">
                <div class="perfil-avatar">
                    <?php echo $primera_letra; ?>
                </div>
                <div class="perfil-details">
                    <h2 class="perfil-name"><?php echo $nombre_usuario; ?></h2>
                    <p class="perfil-email"><?php echo $correo_usuario; ?></p>
                    <button class="btn-edit-profile" id="btn-edit-profile">Editar perfil</button>
                </div>
            </div>
            
            <div class="perfil-tabs">
                <div class="perfil-tab active" data-tab="info">Información del perfil</div>
                <div class="perfil-tab" data-tab="security">Seguridad</div>
            </div>
            
            <!-- Tab: Información del perfil -->
            <div class="perfil-tab-content active" id="tab-info">
                <div class="perfil-section">
                    <h3 class="perfil-section-title">Información del perfil</h3>
                    
                    <div class="perfil-data">
                        <div class="perfil-data-row">
                            <div class="perfil-data-label">Nombre</div>
                            <div class="perfil-data-value"><?php echo $nombre_usuario; ?></div>
                        </div>
                        
                        <div class="perfil-data-row">
                            <div class="perfil-data-label">Correo electrónico</div>
                            <div class="perfil-data-value"><?php echo $correo_usuario; ?></div>
                        </div>
                        
                        <?php if (!empty($documento_usuario)): ?>
                        <div class="perfil-data-row">
                            <div class="perfil-data-label">Documento</div>
                            <div class="perfil-data-value"><?php echo $documento_usuario; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($telefono_usuario)): ?>
                        <div class="perfil-data-row">
                            <div class="perfil-data-label">Teléfono</div>
                            <div class="perfil-data-value"><?php echo $telefono_usuario; ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Formulario de edición (oculto por defecto) -->
                    <div id="edit-profile-form" style="display: none;">
                        <form id="form-info-personal">
                            <div class="perfil-form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="perfil-form-control" id="nombre" name="nombre" value="<?php echo $nombre_usuario; ?>">
                            </div>
                            
                            <div class="perfil-form-group">
                                <label for="correo">Correo electrónico</label>
                                <input type="email" class="perfil-form-control" id="correo" name="correo" value="<?php echo $correo_usuario; ?>">
                            </div>
                            
                            <?php if (!empty($telefono_usuario) || true): ?>
                            <div class="perfil-form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="perfil-form-control" id="telefono" name="telefono" value="<?php echo $telefono_usuario; ?>">
                            </div>
                            <?php endif; ?>
                            
                            <div class="form-actions">
                                <button type="button" class="perfil-btn-outline" id="btn-cancel-edit">Cancelar</button>
                                <button type="submit" class="perfil-btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            
            <!-- Tab: Seguridad -->
            <div class="perfil-tab-content" id="tab-security">
                <div class="perfil-section">
                    <h3 class="perfil-section-title">Cambiar contraseña</h3>
                    
                    <form id="form-cambiar-password">
                        <div class="perfil-form-group">
                            <label for="password_actual">Contraseña actual</label>
                            <input type="password" class="perfil-form-control" id="password_actual" name="password_actual" required>
                        </div>
                        
                        <div class="perfil-form-group">
                            <label for="password_nuevo">Nueva contraseña</label>
                            <input type="password" class="perfil-form-control" id="password_nuevo" name="password_nuevo" required>
                            <small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres</small>
                        </div>
                        
                        <div class="perfil-form-group">
                            <label for="password_confirmar">Confirmar nueva contraseña</label>
                            <input type="password" class="perfil-form-control" id="password_confirmar" name="password_confirmar" required>
                        </div>
                        
                        <button type="submit" class="perfil-btn-primary">Cambiar contraseña</button>
                    </form>
                </div>
                
                <div class="perfil-section">
                    <h3 class="perfil-section-title">Seguridad de la cuenta</h3>
                    
                    <div class="perfil-data">
                        <div class="perfil-data-row">
                            <div class="perfil-data-label">Último inicio de sesión</div>
                            <div class="perfil-data-value">Hoy</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tab: Mis pedidos -->
            <div class="perfil-tab-content" id="tab-orders">
                <div class="perfil-section">
                    <h3 class="perfil-section-title">Pedidos recientes</h3>
                    
                    <?php if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0): ?>
                        <table class="perfil-table">
                            <thead>
                                <tr>
                                    <th>Número de orden</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pedido = mysqli_fetch_assoc($resultado_pedidos)): ?>
                                    <tr>
                                        <td>#<?php echo $pedido['id']; ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></td>
                                        <td>$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                                $estado_class = '';
                                                
                                                switch($pedido['estado']) {
                                                    case 'aprobado': $estado_class = 'success'; break;
                                                    case 'pendiente': $estado_class = 'warning'; break;
                                                    case 'cancelado': $estado_class = 'danger'; break;
                                                    default: $estado_class = 'secondary';
                                                }
                                            ?>
                                            <span class="perfil-badge perfil-badge-<?php echo $estado_class; ?>">
                                                <?php echo ucfirst($pedido['estado']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="detalle-pedido.php?id=<?php echo $pedido['id']; ?>" class="perfil-btn-outline btn-sm">
                                                Ver detalle
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        
                        <div class="text-center mt-4">
                            <a href="historial-compras.php" class="perfil-btn-outline">Ver todos mis pedidos</a>
                        </div>
                    <?php else: ?>
                        <div class="perfil-empty-state">
                            <div class="perfil-empty-state-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h4 class="perfil-empty-state-title">No tienes pedidos recientes</h4>
                            <p class="perfil-empty-state-text">¡Explora nuestra tienda y realiza tu primer pedido!</p>
                            <a href="productos.php" class="perfil-btn-primary">Ver productos</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts específicos para la página de perfil -->
<script>
$(document).ready(function() {
    // Cambiar entre pestañas
    $('.perfil-tab').on('click', function() {
        const tabId = $(this).data('tab');
        
        // Activar la pestaña
        $('.perfil-tab').removeClass('active');
        $(this).addClass('active');
        
        // Mostrar el contenido correspondiente
        $('.perfil-tab-content').removeClass('active');
        $(`#tab-${tabId}`).addClass('active');
    });
    
    // Mostrar/ocultar formulario de edición
    $('#btn-edit-profile').on('click', function() {
        $('.perfil-data').hide();
        $('#edit-profile-form').show();
    });
    
    // Cancelar edición
    $('#btn-cancel-edit').on('click', function() {
        $('#edit-profile-form').hide();
        $('.perfil-data').show();
    });
    
    // Formulario de información personal
    $('#form-info-personal').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            nombre: $('#nombre').val(),
            correo: $('#correo').val(),
            telefono: $('#telefono').val(),
            id: <?php echo $id_usuario; ?>
        };
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando cambios',
            html: 'Por favor espera...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            type: 'POST',
            url: 'funciones/actualizar_perfil.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Perfecto!',
                        text: 'Tu información ha sido actualizada correctamente',
                        confirmButtonColor: '#e3a04b'
                    }).then(() => {
                        // Actualizar la página para mostrar los cambios
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ha ocurrido un error al actualizar tu información',
                        confirmButtonColor: '#e3a04b'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al procesar tu solicitud',
                    confirmButtonColor: '#e3a04b'
                });
            }
        });
    });
    
    // Formulario de cambio de contraseña
    $('#form-cambiar-password').on('submit', function(e) {
        e.preventDefault();
        
        var password_nuevo = $('#password_nuevo').val();
        var password_confirmar = $('#password_confirmar').val();
        
        if (password_nuevo !== password_confirmar) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden',
                confirmButtonColor: '#e3a04b'
            });
            return;
        }
        
        if (password_nuevo.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe tener al menos 8 caracteres',
                confirmButtonColor: '#e3a04b'
            });
            return;
        }
        
        var formData = {
            password_actual: $('#password_actual').val(),
            password_nuevo: password_nuevo,
            id: <?php echo $id_usuario; ?>
        };
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Actualizando contraseña',
            html: 'Por favor espera...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            type: 'POST',
            url: 'funciones/cambiar_password.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Perfecto!',
                        text: 'Tu contraseña ha sido actualizada correctamente',
                        confirmButtonColor: '#e3a04b'
                    }).then(() => {
                        $('#form-cambiar-password')[0].reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ha ocurrido un error al cambiar tu contraseña',
                        confirmButtonColor: '#e3a04b'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al procesar tu solicitud',
                    confirmButtonColor: '#e3a04b'
                });
            }
        });
    });
});
</script>

<?php include 'includes/footer.html'; ?>
