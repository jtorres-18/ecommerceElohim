function generarNumeroFactura() {
    return Date.now() + Math.floor(Math.random() * 1000);
}

function clearCart() {
    $.ajax({
        type: "POST",
        url: "funciones/funciones_carrito.php",
        dataType: "json",
        data: { accion: "limpiarTodoElCarrito" },
        success: function(response) {
            if (response.estado === "OK") {
                localStorage.removeItem("miProducto");
                // La redirección se manejará en finalizar_compra
            }
        },
        error: function(xhr) {
            console.error("Error al limpiar el carrito:", xhr.responseText);
        }
    });
}

function finalizar_compra(e) {
    e.preventDefault();
    const direccion = document.getElementById("direccion").value;
    const telefono = document.getElementById("telefono").value;
    const metodo_pago = document.getElementById("metodo_pago").value;
    const total_venta = document.getElementById("totalPuntos").textContent;
    const factura = generarNumeroFactura();
    const id_cliente = sessionStorage.getItem("id_cliente");

    if (direccion && telefono && metodo_pago) {
        Swal.fire({
            title: 'Procesando pedido',
            html: 'Por favor espera...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: "post",
            url: "funciones/venta.php",
            data: {
                direccion: direccion,
                telefono: telefono,
                metodo_pago: metodo_pago,
                total_venta: total_venta,
                factura: factura,
                id_cliente: id_cliente
            },
            success: function(respuesta) {
                Swal.close();
                
                try {
                    const data = typeof respuesta === 'string' ? JSON.parse(respuesta) : respuesta;
                
                    if (data.success) {
                        // Obtener detalle del pedido
                        obtener_detalle(data.id);
                        
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pedido realizado!',
                            text: 'Serás redirigido a la página de productos',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            // Limpiar carrito
                            clearCart();
                            
                            // Cerrar modal
                            $("#checkoutModal").modal('hide');
                            
                            // Redirigir a productos.php
                            window.location.href = "productos.php";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al procesar',
                            text: data.error || 'Ocurrió un error al guardar el pedido'
                        });
                    }
                } catch (e) {
                    console.error("Error al parsear respuesta:", e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'La respuesta del servidor no pudo ser procesada'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor'
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Datos incompletos',
            text: 'Por favor completa todos los campos requeridos'
        });
    }
}

function registrar_detalle(carrito, id_venta) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "post",
            url: "funciones/guardar_pedido.php",
            data: {
                cantidad: carrito.cantidad,
                id_producto: carrito.producto_id,
                id_venta: id_venta
            },
            success: function(respuesta) {
                resolve(respuesta);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
}

function obtener_detalle(id_venta) {
    const token = sessionStorage.getItem("clientToken");
    
    $.ajax({
        type: "post",
        url: "funciones/obtener_productos.php",
        data: { token: token },
        success: function(respuesta) {
            try {
                const lista = JSON.parse(respuesta);
                const promises = [];
                
                for (let i = 0; i < lista.length; i++) {
                    promises.push(registrar_detalle(lista[i], id_venta));
                }
                
                Promise.all(promises)
                    .then(() => console.log("Todos los detalles guardados"))
                    .catch(error => console.error("Error al guardar detalles:", error));
            } catch (e) {
                console.error("Error al parsear productos:", e);
            }
        },
        error: function(xhr) {
            console.error("Error al obtener productos:", xhr.responseText);
        }
    });
}

// Inicialización del evento
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("btnFinalizarCompra");
    if (btn) {
        btn.addEventListener("click", finalizar_compra);
    }
});