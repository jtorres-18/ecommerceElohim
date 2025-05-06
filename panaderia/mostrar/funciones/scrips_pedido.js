

function generarNumeroFactura() {
    return Date.now() + Math.floor(Math.random() * 1000);
}



function clearCart() {
    let dataString = `accion=limpiarTodoElCarrito`;
    axios
    .post(ruta, dataString)
    .then(function (response) {
        if (response.data.mensaje == 1) {
        localStorage.removeItem("miProducto");
        window.location.href = 'productos.php';
        }
    })
    .catch(function (error) {
        console.error("Error:", error);
    });
}

function finalizar_compra(e){
    e.preventDefault ();
    const direccion = document.getElementById("direccion").value
    const telefono = document.getElementById("telefono").value
    const metodo_pago = document.getElementById("metodo_pago").value
    const total_venta = document.getElementById("totalPuntos").textContent;
    const factura = generarNumeroFactura();
    const id_cliente = sessionStorage.getItem("id_cliente");
    if(direccion!== "" && telefono!== "" && metodo_pago!== ""){
    $.ajax({
        type: "post",
        url: "funciones/venta.php",
        data: {
        direccion: direccion,
        telefono: telefono,
        metodo_pago: metodo_pago,
        total_venta: total_venta,
        factura: factura,
        id_cliente:id_cliente
        },
        success: function(respuesta) {
            const data = JSON.parse(respuesta);
            obtener_detalle(data.id)
            Swal.fire({
                    icon: 'success',
                    title: 'pedido realizado con exito',
                    showConfirmButton: false,
                    timer: 3000
                })
                setTimeout(function() {
                    clearCart();
                    $("#exampleModal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('body').removeAttr('style');
                    modal.style.display = 'none';
                }, 3000);
        }
        
    })
        
    }else{
        Swal.fire({
                    icon: 'error',
                    title: 'uno o mas campos estan vacios',
                    showConfirmButton: false,
                    timer: 3000
                })
    }
}






function registrar_detalle(carrito, id_venta){
    console.log(carrito);
    $.ajax({
        type: "post",
        url: "funciones/guardar_pedido.php",
        data: {
        cantidad: carrito.cantidad,
        id_producto: carrito.producto_id,
        id_venta: id_venta
        },
        success: function(respuesta) {
            console.log(respuesta)    
        },
        error: function(error){
            if (error.status === 404) {
      throw "La página no se encontró";
    } else if (error.status === 500) {
      throw "Error interno del servidor";
    } else {
      throw "Error desconocido";
    }
        }
    })
        
    
}



function obtener_detalle(id_venta){
    const token=localStorage.getItem("miProducto");
    let lista = [];
    $.ajax({
        type: "post",
        url: "funciones/obtener_productos.php",
        data:{
          token: token 
        },
        success: function(respuesta) {
            const data = JSON.parse(respuesta);
            lista = data
              for (let i = 0; i < lista.length; i++) {
                    registrar_detalle(lista[i], id_venta);
                }
        }
    })
        
    
}