function agregar(e) {
    // Prevenir el comportamiento predeterminado del formulario
    e.preventDefault();

    // Obtener valores de los elementos del formulario
    const codigo = $('#codigo').val()
    const nombre =  $('#nameProd').val()
    const precio = $('#precio').val()
    const descripcion = $('#descripcion').val()
    let categoria = (document.getElementById("categoria").value === "Panaderia") ? 1 : 2;
    const fotoInput = $('#customFile')[0];  // Obtener el elemento DOM del campo de archivo
    const foto = fotoInput.files[0];      
    const formData = new FormData();  // Asegúrate de crear el objeto FormData aquí

    formData.append("codigo", codigo);
    formData.append("nameProd", nombre);
    formData.append("precio", precio);
    formData.append("descripcion", descripcion);
    formData.append("categoria", categoria);
    formData.append("foto1", foto);
    $.ajax({
        type: "post",
        url: "procesar_producto.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    title: "¡Genial!",
                    text: "agrgado con exito.",
                    icon: "success"
                });
                setTimeout(function () {
                    window.location.href = "listar_productos.php";
                }, 1500);
            }
        },
        error: function (error) {
            console.error("Error:", error);
        }
    });

    }


