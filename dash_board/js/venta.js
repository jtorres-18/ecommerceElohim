function agregar(event) {
    event.preventDefault();
    const id_producto = document.getElementById("codigo").value;
    const cantidad = document.getElementById("cantidad").value;

    $.ajax({
        type: "POST",
        url: "agregar_producto_temporal.php",
        data: { id_producto, cantidad },
        success: function(res) {
            const data = res; // ✅ aquí estaba el error
            if (data.success) {
                renderCarrito(data.carrito);
                Swal.fire("Producto agregado correctamente", "", "success");
                document.getElementById("codigo").value = "";
                document.getElementById("cantidad").value = "";
            } else {
                Swal.fire("Error", data.message, "error");
            }
        }
    });
}


function renderCarrito(carrito) {
    const tbody = document.getElementById("tablaCarritoBody");
    const totalDisplay = document.getElementById("totalPagar");
    tbody.innerHTML = "";

    let total = 0;

    carrito.forEach((p, index) => {
        total += parseFloat(p.subtotal);
        tbody.innerHTML += `
            <tr>
                <td>${p.codigo}</td>
                <td>${p.nombre}</td>
                <td>$${p.precio}</td>
                <td>${p.cantidad}</td>
                <td>$${p.subtotal}</td>
                <td><button class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">X</button></td>
            </tr>`;
    });

    totalDisplay.textContent = "$" + total.toFixed(2);
}

function limpiarCarritoUI() {
    document.getElementById("tablaCarritoBody").innerHTML = "";
    document.getElementById("totalPagar").textContent = "$0";
    document.getElementById("codigo").value = "";
    document.getElementById("cantidad").value = "";
    document.getElementById("metodo_pago").selectedIndex = 0;
}



function confirmarVenta() {
    const metodo_pago = document.getElementById("metodo_pago").value;

    $.ajax({
        type: "POST",
        url: "confirmar_venta.php",
        data: { metodo_pago },
        success: function(res) {
            console.log("Respuesta del servidor:", res); // 👈 LOG para ver el error real

            const data = typeof res === "object" ? res : JSON.parse(res);

            if (data.success) {
                Swal.fire("Éxito", data.message, "success").then(() => {
                    limpiarCarritoUI();
                    mostrarFactura(data);
                });
            } else {
                Swal.fire("Error", data.message || "Ocurrió un error", "error");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", error);
            console.log("Respuesta:", xhr.responseText);
            Swal.fire("Error inesperado", xhr.responseText, "error");
        }
    });
}


function eliminarProducto(index) {
    $.ajax({
        type: "POST",
        url: "eliminar_producto_temporal.php",
        data: { index },
        success: function(res) {
            const data = typeof res === "object" ? res : JSON.parse(res);

            if (data.success) {
                renderCarrito(data.carrito);
                Swal.fire("Eliminado", "Producto eliminado del carrito", "success");
            } else {
                Swal.fire("Error", data.message, "error");
            }
        }
    });
}