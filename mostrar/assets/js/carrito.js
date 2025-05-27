$(document).ready(() => {
  // Cargar el carrito desde localStorage al iniciar
  cargarCarrito()

  // Evento para agregar productos al carrito
  $(document).on("click", "#agregar_carrito, .agregar-carrito", function () {
    console.log("Botón de agregar al carrito clickeado")

    // Obtener datos del producto
    const id = $(this).data("id")
    const nombre = $(this).data("nombre")
    const precio = $(this).data("precio")
    const imagen = $(this).data("imagen")
    let cantidad = 1

    // Si estamos en la página de detalles, obtener la cantidad seleccionada
    if ($("#cantidad").length) {
      cantidad = Number.parseInt($("#cantidad").val())
    }

    // Verificar que los datos sean válidos
    if (!id || !nombre || !precio) {
      console.error("Datos de producto incompletos:", { id, nombre, precio, imagen })
      return
    }

    // Agregar al carrito
    agregarAlCarrito(id, nombre, precio, cantidad, imagen)

    // Mostrar mensaje de éxito
    alert("Producto agregado al carrito")
  })

  // Evento para eliminar productos del carrito
  $(document).on("click", ".eliminar-producto", function () {
    const id = $(this).data("id")
    eliminarDelCarrito(id)
  })

  // Evento para vaciar el carrito
  $(document).on("click", "#vaciar-carrito", () => {
    vaciarCarrito()
  })

  // Función para agregar productos al carrito
  function agregarAlCarrito(id, nombre, precio, cantidad, imagen) {
    const carrito = obtenerCarrito()

    // Verificar si el producto ya está en el carrito
    const index = carrito.findIndex((item) => item.id === id)

    if (index !== -1) {
      // Si ya existe, aumentar la cantidad
      carrito[index].cantidad += cantidad
    } else {
      // Si no existe, agregar nuevo producto
      carrito.push({
        id: id,
        nombre: nombre,
        precio: precio,
        cantidad: cantidad,
        imagen: imagen,
      })
    }

    // Guardar carrito actualizado
    localStorage.setItem("carrito", JSON.stringify(carrito))

    // Actualizar contador y lista del carrito
    actualizarContadorCarrito()
    cargarCarrito()
  }

  // Función para eliminar un producto del carrito
  function eliminarDelCarrito(id) {
    let carrito = obtenerCarrito()
    carrito = carrito.filter((item) => item.id !== id)
    localStorage.setItem("carrito", JSON.stringify(carrito))

    // Actualizar contador y lista del carrito
    actualizarContadorCarrito()
    cargarCarrito()

    // Si estamos en la página del carrito, actualizar la tabla
    if ($("#tabla-carrito").length) {
      mostrarCarritoEnTabla()
    }
  }

  // Función para vaciar el carrito
  function vaciarCarrito() {
    localStorage.setItem("carrito", JSON.stringify([]))

    // Actualizar contador y lista del carrito
    actualizarContadorCarrito()
    cargarCarrito()

    // Si estamos en la página del carrito, actualizar la tabla
    if ($("#tabla-carrito").length) {
      mostrarCarritoEnTabla()
    }
  }

  // Función para obtener el carrito actual
  function obtenerCarrito() {
    const carritoJSON = localStorage.getItem("carrito")
    return carritoJSON ? JSON.parse(carritoJSON) : []
  }

  // Función para actualizar el contador del carrito
  function actualizarContadorCarrito() {
    const carrito = obtenerCarrito()
    const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0)
    $("#contador-carrito").text(totalItems)
  }

  // Función para cargar y mostrar el carrito
  function cargarCarrito() {
    actualizarContadorCarrito()

    // Si estamos en la página del carrito, mostrar la tabla
    if ($("#tabla-carrito").length) {
      mostrarCarritoEnTabla()
    }
  }

  // Función para mostrar el carrito en una tabla (página de carrito)
  function mostrarCarritoEnTabla() {
    const carrito = obtenerCarrito()
    let html = ""
    let total = 0

    if (carrito.length === 0) {
      html = '<tr><td colspan="5" class="text-center">No hay productos en el carrito</td></tr>'
      $("#total-carrito").text("$0")
    } else {
      carrito.forEach((item) => {
        const subtotal = item.precio * item.cantidad
        total += subtotal

        html += `
                <tr>
                    <td>
                        <img src="${item.imagen}" alt="${item.nombre}" width="50">
                    </td>
                    <td>${item.nombre}</td>
                    <td>$${item.precio.toFixed(2)}</td>
                    <td>${item.cantidad}</td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm eliminar-producto" data-id="${item.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `
      })

      $("#total-carrito").text("$" + total.toFixed(2))
    }

    $("#tabla-carrito tbody").html(html)
  }
})

$(document).ready(() => {
  // Función para generar un token único
  function generateToken() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
  }

  // Verificar si existe un token en sessionStorage, si no, crear uno
  if (!sessionStorage.getItem("clientToken")) {
     sessionStorage.setItem("clientToken", generateToken())
  }

  // Agregar producto al carrito
  $(document).on("click", ".add-to-cart-btn", function () {
    const idProduct = $(this).data("id")
    const precio = $(this).data("precio")
    const tokenCliente = $(this).data("token")
    let cantidad = 1

    // Si estamos en la página de detalles, obtener la cantidad del input
    if ($("#quantity").length) {
      cantidad = Number.parseInt($("#quantity").val())
    }

    console.log("Agregando producto:", idProduct, "Precio:", precio, "Token:", tokenCliente, "Cantidad:", cantidad)

    $.ajax({
      url: "funciones/funciones_carrito.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: "addCar",
        idProduct: idProduct,
        precio: precio,
        tokenCliente: tokenCliente,
        cantidad: cantidad,
      },
      success: (response) => {
        console.log("Respuesta del servidor:", response)
        alert("Producto agregado al carrito")
        // Actualizar el contador del carrito
        $(".cart-icon").text(response)
      },
      error: (xhr, status, error) => {
        console.error("Error al agregar al carrito:", xhr.responseText)
        alert("Error al agregar al carrito")
      },
    })
  })

  // Aumentar cantidad en el carrito
  $(document).on("click", ".btn-aumentar", function () {
    const idProd = $(this).data("id")
    const precio = $(this).data("precio")
    const tokenCliente = $(this).data("token")
    const cantidadActual = Number.parseInt($(this).closest("tr").find(".cantidad-producto").text())
    const nuevaCantidad = cantidadActual + 1

    $.ajax({
      url: "funciones/funciones_carrito.php",
      type: "POST",
      dataType: "json",
      data: {
        aumentarCantidad: nuevaCantidad,
        idProd: idProd,
        precio: precio,
        tokenCliente: tokenCliente,
      },
      success: function (response) {
        if (response.estado === "OK") {
          // Actualizar la cantidad en la tabla
          $(this).closest("tr").find(".cantidad-producto").text(nuevaCantidad)
          // Actualizar el total a pagar
          $("#totalPagar").text(response.totalPagar)
        }
      }.bind(this),
      error: (xhr, status, error) => {
        console.error("Error al aumentar cantidad:", error)
      },
    })
  })

  // Disminuir cantidad en el carrito
  $(document).on("click", ".btn-disminuir", function () {
    const idProd = $(this).data("id")
    const precio = $(this).data("precio")
    const tokenCliente = $(this).data("token")
    const cantidadActual = Number.parseInt($(this).closest("tr").find(".cantidad-producto").text())
    const nuevaCantidad = cantidadActual - 1

    if (nuevaCantidad >= 0) {
      $.ajax({
        url: "funciones/funciones_carrito.php",
        type: "POST",
        dataType: "json",
        data: {
          accion: "disminuirCantidad",
          idProd: idProd,
          precio: precio,
          tokenCliente: tokenCliente,
          cantidad_Disminuida: nuevaCantidad,
        },
        success: function (response) {
          if (response.estado === "OK") {
            if (nuevaCantidad === 0) {
              // Si la cantidad es 0, eliminar la fila
              $(this).closest("tr").remove()
            } else {
              // Actualizar la cantidad en la tabla
              $(this).closest("tr").find(".cantidad-producto").text(nuevaCantidad)
            }

            // Actualizar el total a pagar
            $("#totalPagar").text(response.totalPagar)

            // Actualizar el contador del carrito
            $(".cart-icon").text(response.totalProductos)

            // Si no hay productos, mostrar mensaje
            if (response.totalProductos === 0) {
              $("#tablaCarrito").hide()
              $("#carritoVacio").show()
            }
          }
        }.bind(this),
        error: (xhr, status, error) => {
          console.error("Error al disminuir cantidad:", error)
        },
      })
    }
  })

  // Eliminar producto del carrito
  $(document).on("click", ".btn-eliminar", function () {
    const idProduct = $(this).data("id")
    const tokenCliente = $(this).data("token")

    $.ajax({
      url: "funciones/funciones_carrito.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: "borrarproductoModal",
        idProduct: idProduct,
        tokenCliente: tokenCliente,
      },
      success: function (response) {
        if (response.estado === "OK") {
          // Eliminar la fila
          $(this).closest("tr").remove()

          // Actualizar el total a pagar
          $("#totalPagar").text(response.totalPagar)

          // Actualizar el contador del carrito
          $(".cart-icon").text(response.totalProductos)

          // Si no hay productos, mostrar mensaje
          if (response.totalProductos === 0) {
            $("#tablaCarrito").hide()
            $("#carritoVacio").show()
          }
        }
      }.bind(this),
      error: (xhr, status, error) => {
        console.error("Error al eliminar producto:", error)
      },
    })
  })

  // Limpiar carrito
  $(document).on("click", "#limpiarCarrito", function () {
    const tokenCliente = $(this).data("token")

    $.ajax({
      url: "funciones/funciones_carrito.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: "limpiarTodoElCarrito",
        tokenCliente: tokenCliente,
      },
      success: (response) => {
        if (response.mensaje === 1) {
          // Vaciar la tabla
          $("#tablaCarrito tbody").empty()

          // Actualizar el contador del carrito
          $(".cart-icon").text("0")

          // Mostrar mensaje de carrito vacío
          $("#tablaCarrito").hide()
          $("#carritoVacio").show()
        }
      },
      error: (xhr, status, error) => {
        console.error("Error al limpiar carrito:", error)
      },
    })
  })
})
