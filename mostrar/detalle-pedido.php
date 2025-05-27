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
    // Redirigir al login si no está autenticado
    header('Location: ../sesion/login.html');
    exit;
}

// Verificar si se proporcionó un ID de pedido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: historial-compras.php');
    exit;
}

require_once 'config/config.php';
require_once 'funciones/funciones_tienda.php';
require_once 'funciones/funciones_pedidos.php';

// Obtener datos del pedido
$pedido_id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar que el pedido pertenezca al usuario
$pedido = obtener_detalle_pedido($con, $pedido_id, $usuario_id);

if (!$pedido) {
    // Si el pedido no existe o no pertenece al usuario, redirigir
    header('Location: historial-compras.php');
    exit;
}

// Obtener los items del pedido
$items_pedido = obtener_items_pedido($con, $pedido_id);

// Incluir el header
include 'header.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Detalle de Pedido #<?php echo $pedido_id; ?> - Elohim</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/nrGQ8SSX/logo.png">
    
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="  type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/responsive.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/historial.css">
    <link rel="stylesheet" href="assets/styles/pedido-detalle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div>
            <span>cargando...</span>
        </div>
    </div>

    <main class="main-content">
        <div class="container mt-4 mb-5">
            <div class="order-detail-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="page-title">Pedido #<?php echo $pedido_id; ?></h1>
                        <div class="order-meta">
                            <span class="order-date">
                                <i class="bi bi-calendar3"></i>
                                <?php echo date('d/m/Y', strtotime($pedido['fecha'])); ?>
                            </span>
                            <span class="order-status <?php echo 'status-' . $pedido['estado']; ?>">
                                <?php 
                                $statusIcon = '';
                                switch ($pedido['estado']) {
                                    case 'pendiente': $statusIcon = 'bi-hourglass-split'; break;
                                    case 'procesando': $statusIcon = 'bi-gear'; break;
                                    case 'enviado': $statusIcon = 'bi-truck'; break;
                                    case 'entregado': $statusIcon = 'bi-check-circle'; break;
                                    case 'cancelado': $statusIcon = 'bi-x-circle'; break;
                                    default: $statusIcon = 'bi-question-circle';
                                }
                                ?>
                                <i class="bi <?php echo $statusIcon; ?>"></i>
                                <?php echo ucfirst(htmlspecialchars($pedido['estado'])); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="historial-compras.php" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Volver a pedidos
                        </a>
                    </div>
                </div>
            </div>

            <div class="order-detail-body mt-4">
                <div class="row">
                    <!-- Información del pedido -->
                    <div class="col-md-4 mb-4">
                        <div class="order-info-card">
                            <h3>Información del Pedido</h3>
                            <div class="order-info-list">
                                <div class="info-item">
                                    <span class="info-label">Método de pago:</span>
                                    <span class="info-value"><?php echo ucfirst(htmlspecialchars($pedido['metodo_pago'])); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total:</span>
                                    <span class="info-value price">$<?php echo number_format($pedido['total'], 0, '', '.'); ?></span>
                                </div>
                                <?php if (!empty($pedido['tracking_number'])): ?>
                                <div class="info-item">
                                    <span class="info-label">Número de seguimiento:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($pedido['tracking_number']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Dirección de entrega -->
                        <div class="order-address-card mt-4">
                            <h3>Dirección de Entrega</h3>
                            <address>
                                <?php echo nl2br(htmlspecialchars($pedido['direccion'])); ?>
                            </address>
                            <div class="contact-info">
                                <div><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($pedido['telefono']); ?></div>
                            </div>
                        </div>
                        
                        <?php if (!empty($pedido['notas'])): ?>
                        <!-- Notas del pedido -->
                        <div class="order-notes-card mt-4">
                            <h3>Notas del Pedido</h3>
                            <p><?php echo nl2br(htmlspecialchars($pedido['notas'])); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Productos del pedido -->
                    <div class="col-md-8">
                        <div class="order-products-card">
                            <h3>Productos</h3>
                            <div class="table-responsive">
                                <table class="table order-items-table">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="80"></th>
                                            <th scope="col">Producto</th>
                                            <th scope="col" class="text-center">Cantidad</th>
                                            <th scope="col" class="text-end">Precio</th>
                                            <th scope="col" class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($items_pedido && mysqli_num_rows($items_pedido) > 0): ?>
                                            <?php while ($item = mysqli_fetch_assoc($items_pedido)): ?>
                                                <tr>
                                                    <td>
                                                        <img src="../dash_board/img/<?php echo htmlspecialchars($item['foto1'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                            alt="<?php echo htmlspecialchars($item['nameProd'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                            class="item-thumbnail">
                                                    </td>
                                                    <td class="item-name">
                                                        <?php echo htmlspecialchars($item['nameProd'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $item['cantidad']; ?></td>
                                                    <td class="text-end">$<?php echo number_format($item['precio'], 0, '', '.'); ?></td>
                                                    <td class="text-end">$<?php echo number_format($item['precio'] * $item['cantidad'], 0, '', '.'); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No se encontraron productos en este pedido.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-end price-total">$<?php echo number_format($pedido['total'], 0, '', '.'); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Historial de estados del pedido -->
                        <div class="order-timeline-card mt-4">
                            <h3>Historial del Pedido</h3>
                            <div class="order-timeline">
                                <?php
                                // Obtener historial de estados si existe la función
                                if (function_exists('obtener_historial_estados_pedido')):
                                    $historial = obtener_historial_estados_pedido($con, $pedido_id);
                                    if ($historial && mysqli_num_rows($historial) > 0):
                                        while ($estado = mysqli_fetch_assoc($historial)):
                                ?>
                                    <div class="timeline-item">
                                        <div class="timeline-icon <?php echo 'status-' . $estado['estado']; ?>">
                                            <?php 
                                            $timelineIcon = '';
                                            switch ($estado['estado']) {
                                                case 'pendiente': $timelineIcon = 'bi-hourglass-split'; break;
                                                case 'procesando': $timelineIcon = 'bi-gear'; break;
                                                case 'enviado': $timelineIcon = 'bi-truck'; break;
                                                case 'entregado': $timelineIcon = 'bi-check-circle'; break;
                                                case 'cancelado': $timelineIcon = 'bi-x-circle'; break;
                                                default: $timelineIcon = 'bi-circle';
                                            }
                                            ?>
                                            <i class="bi <?php echo $timelineIcon; ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h4><?php echo ucfirst(htmlspecialchars($estado['estado'])); ?></h4>
                                            <time><?php echo date('d/m/Y H:i', strtotime($estado['fecha'])); ?></time>
                                            <?php if (!empty($estado['comentario'])): ?>
                                                <p><?php echo htmlspecialchars($estado['comentario']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php 
                                        endwhile;
                                    else:
                                ?>
                                    <div class="timeline-item">
                                        <div class="timeline-icon status-<?php echo $pedido['estado']; ?>">
                                            <i class="bi <?php echo $statusIcon; ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h4><?php echo ucfirst(htmlspecialchars($pedido['estado'])); ?></h4>
                                            <time><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></time>
                                            <p>Estado actual del pedido</p>
                                        </div>
                                    </div>
                                <?php 
                                    endif;
                                else:
                                ?>
                                    <div class="timeline-item">
                                        <div class="timeline-icon status-<?php echo $pedido['estado']; ?>">
                                            <i class="bi <?php echo $statusIcon; ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h4><?php echo ucfirst(htmlspecialchars($pedido['estado'])); ?></h4>
                                            <time><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></time>
                                            <p>Estado actual del pedido</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Valoración del pedido (si está entregado) -->
                        <?php if ($pedido['estado'] === 'entregado'): ?>
                            <?php if (isset($pedido['valoracion']) && $pedido['valoracion'] > 0): ?>
                                <div class="order-rating-card mt-4">
                                    <h3>Tu Valoración</h3>
                                    <div class="rating-display">
                                        <div class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi <?php echo ($i <= $pedido['valoracion']) ? 'bi-star-fill' : 'bi-star'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="rating-date">
                                            Valorado el <?php echo date('d/m/Y', strtotime($pedido['fecha_valoracion'])); ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($pedido['comentario_valoracion'])): ?>
                                        <div class="rating-comment">
                                            <p><?php echo nl2br(htmlspecialchars($pedido['comentario_valoracion'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="order-rating-prompt mt-4">
                                    <h3>Valorar este Pedido</h3>
                                    <p>¿Cómo ha sido tu experiencia con este pedido? Tu opinión nos ayuda a mejorar.</p>
                                    <button type="button" class="btn btn-primary" id="openRatingModal" data-pedido-id="<?php echo $pedido_id; ?>">
                                        <i class="bi bi-star"></i> Valorar ahora
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Valoración -->
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Valorar Pedido #<?php echo $pedido_id; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ratingForm">
                        <input type="hidden" id="pedido_id" name="pedido_id" value="<?php echo $pedido_id; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">¿Cómo calificarías tu experiencia?</label>
                            <div class="rating-stars">
                                <i class="bi bi-star" data-value="1"></i>
                                <i class="bi bi-star" data-value="2"></i>
                                <i class="bi bi-star" data-value="3"></i>
                                <i class="bi bi-star" data-value="4"></i>
                                <i class="bi bi-star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="rating_value" name="rating_value" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentarios (opcional)</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Cuéntanos tu experiencia con este pedido"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="submitRating" class="btn btn-primary">Enviar valoración</button>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.html'); ?>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/styles/bootstrap4/popper.js"></script>
    <script src="assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/loader.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar el modal de valoración
            const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));
            
            // Mostrar modal de valoración
            $('#openRatingModal').click(function() {
                resetRatingForm();
                ratingModal.show();
            });
            
            // Sistema de valoración por estrellas
            $('.rating-stars i').on('mouseover', function() {
                const rating = $(this).data('value');
                highlightStars(rating);
            });
            
            $('.rating-stars').on('mouseleave', function() {
                const currentRating = $('#rating_value').val();
                if (currentRating) {
                    highlightStars(currentRating);
                } else {
                    $('.rating-stars i').removeClass('bi-star-fill').addClass('bi-star');
                }
            });
            
            $('.rating-stars i').on('click', function() {
                const rating = $(this).data('value');
                $('#rating_value').val(rating);
                highlightStars(rating);
            });
            
            // Enviar valoración
            $('#submitRating').click(function() {
                const pedidoId = $('#pedido_id').val();
                const rating = $('#rating_value').val();
                const comentario = $('#comentario').val();
                
                if (!rating) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Se requiere una valoración',
                        text: 'Por favor, selecciona entre 1 y 5 estrellas',
                        confirmButtonColor: '#e67e22'
                    });
                    return;
                }
                
                // Enviar la valoración mediante AJAX
                $.ajax({
                    url: 'funciones/valorar_pedido.php',
                    type: 'POST',
                    data: {
                        pedido_id: pedidoId,
                        rating: rating,
                        comentario: comentario
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            ratingModal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Gracias por tu valoración!',
                                text: 'Tu opinión nos ayuda a mejorar',
                                confirmButtonColor: '#e67e22'
                            }).then(() => {
                                // Actualizar la página para reflejar la valoración
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Ocurrió un error al procesar tu valoración',
                                confirmButtonColor: '#e67e22'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de conexión',
                            text: 'No se pudo conectar con el servidor. Por favor, intenta de nuevo más tarde.',
                            confirmButtonColor: '#e67e22'
                        });
                    }
                });
            });
            
            // Función para resaltar estrellas
            function highlightStars(rating) {
                $('.rating-stars i').each(function() {
                    const value = $(this).data('value');
                    if (value <= rating) {
                        $(this).removeClass('bi-star').addClass('bi-star-fill');
                    } else {
                        $(this).removeClass('bi-star-fill').addClass('bi-star');
                    }
                });
            }
            
            // Función para resetear el formulario de valoración
            function resetRatingForm() {
                $('#rating_value').val('');
                $('#comentario').val('');
                $('.rating-stars i').removeClass('bi-star-fill').addClass('bi-star');
            }
        });
    </script>
</body>

</html>
