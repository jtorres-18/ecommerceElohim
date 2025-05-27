$(() => {
  cargarHistorial()
  $("#filtro_estado, #filtro_periodo").on("change", cargarHistorial)
})

function cargarHistorial() {
  const estado = $("#filtro_estado").val()
  const periodo = $("#filtro_periodo").val()

  $.get("listar_pedidos_usuario.php", { estado, periodo }, (res) => {
    // si viene string, lo parseamos
    const data = typeof res === "object" ? res : JSON.parse(res)
    const $t = $("#tablaHistorialPedidos").empty()

    if (!data.success) {
      return $t.append(`<tr><td colspan="5" class="text-danger">${data.message}</td></tr>`)
    }

    data.pedidos.forEach((p) => {
      $t.append(`
        <tr>
          <td>${p.factura}</td>
          <td>${p.fecha_hora}</td>
          <td>${p.estado_nombre}</td>
          <td>$${p.total_venta}</td>
          <td>
            <button class="btn btn-primary btn-sm"
                    onclick="verDetalles('${p.factura}')">
              Ver detalles
            </button>
          </td>
        </tr>
      `)
    })
  }).fail(() => {
    Swal.fire({ icon: "error", title: "Error", text: "No se pudo cargar el historial." })
  })
}

// Modificar la función verDetalles para añadir depuración y asegurar que los datos se muestran correctamente
function verDetalles(factura) {
  console.log("Solicitando detalles para factura:", factura)

  $.ajax({
    url: "funciones/detalle-pedido-json.php",
    data: { factura },
    dataType: "json",
  })
    .done((res) => {
      console.log("Respuesta completa del servidor:", res)

      if (!res.success) {
        return Swal.fire({ icon: "error", title: "Error", text: res.message })
      }

      // Verificar si hay productos
      if (!res.productos || res.productos.length === 0) {
        console.warn("No se encontraron productos en la respuesta")
      } else {
        console.log("Productos encontrados:", res.productos.length)
      }

      // formateamos la fecha
      const fecha = new Date(res.fecha_hora).toLocaleString("es-CO", {
        day: "2-digit",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      })

      // construimos un grid de 4 columnas para los datos clave
      const headerHTML = `
      <p class="lead">
        Orden <strong>#${res.factura}</strong> se realizó el <strong>${fecha}</strong>
        y actualmente está en <strong>${res.estado}</strong>.
      </p>

      <div class="row text-center mb-4">
        <div class="col-sm-3 mb-3">
          <h6 class="text-uppercase">Número de orden</h6>
          <p class="mb-0">${res.factura}</p>
        </div>
        <div class="col-sm-3 mb-3">
          <h6 class="text-uppercase">Fecha</h6>
          <p class="mb-0">${res.fecha_hora}</p>
        </div>
        <div class="col-sm-3 mb-3">
          <h6 class="text-uppercase">Total</h6>
          <p class="mb-0">$${res.total_venta}</p>
        </div>
        <div class="col-sm-3 mb-3">
          <h6 class="text-uppercase">Forma de pago</h6>
          <p class="mb-0 text-capitalize">${res.metodo_pago}</p>
        </div>
      </div>
    `

      // Generar filas de productos o mensaje si no hay productos
      let productosRows = ""
      if (res.productos && res.productos.length > 0) {
        productosRows = res.productos
          .map(
            (p) => `
          <tr>
            <td>${p.nameProd}</td>
            <td class="text-end">${p.cantidad}</td>
            <td class="text-end">$${p.precio.toFixed(0)}</td>
            <td class="text-end">$${p.subtotal.toFixed(0)}</td>
          </tr>
        `,
          )
          .join("")
      } else {
        productosRows = `<tr><td colspan="4" class="text-center">No se encontraron productos para esta orden</td></tr>`
      }

      // tabla sólo para el detalle de productos
      const productosHTML = `
        <h6 class="mb-3">Detalle de la orden</h6>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead class="table-light">
              <tr>
                <th>Producto</th>
                <th class="text-end">Cantidad</th>
                <th class="text-end">Precio</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              ${productosRows}
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="3" class="text-end">Subtotal:</th>
                <th class="text-end">$${res.subtotal.toFixed(0)}</th>
              </tr>
              <tr>
                <th colspan="3" class="text-end">Envío:</th>
                <th class="text-end">$${res.envio}</th>
              </tr>
              <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th class="text-end">$${res.total_venta.toFixed(0)}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      `

      // direcciones
      const direccionesHTML = `
        <div class="row mt-4">
          <div class="col-md-6">
            <h6 class="text-uppercase">Dirección de facturación</h6>
            <p>${res.direccion_facturacion || "N/A"}</p>
          </div>
          <div class="col-md-6">
            <h6 class="text-uppercase">Dirección de envío</h6>
            <p>${res.direccion_envio}</p>
          </div>
        </div>
      `

      // inyectamos todo junto
      $("#detallePedidoModal .modal-body").html(headerHTML + productosHTML + direccionesHTML)

      // mostramos el modal (ya debe tener .modal-xl en el diálogo)
      new bootstrap.Modal(document.getElementById("detallePedidoModal")).show()
    })
    .fail((xhr) => {
      console.error("Error en la solicitud AJAX:", xhr)
      Swal.fire({ icon: "error", title: "Error", text: "No se pudo cargar el detalle. Código: " + xhr.status })
    })
}
