function eliminarProducto(codigo) {
    Swal.fire({
        title: "¿Estás seguro de eliminar este producto?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "eliminar.php",
                data: {
                    codigo: codigo
                },
                success: function (respuesta) {
                    if (respuesta == 1) {
                    // Usuario hizo clic en "Sí, eliminar"
            Swal.fire({
                title: "¡Eliminado!",
                    text: "Su archivo ha sido eliminado.",
                    icon: "success"
                });
                setTimeout(function () {
                    location.reload();
                }, 1500);
                }else{
                    Swal.fire({
                        title: "¡no se puede eliminar!",
                            text: "desactiva este productos desde editar",
                            icon: "error"
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                }
                },
                error: function (error) {
                    console.error("Error:", error);
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Usuario hizo clic en "Cancelar" o hizo clic fuera del cuadro de diálogo
            Swal.fire("Cancelado", "La eliminación ha sido cancelada.", "info");
        }
    });
    
}






function editarProducto() {
            const id =  $('#id').val()
            const codigo = $('#codigo').val()
            const nombre =  $('#nameProd').val()
            const precio = $('#precio').val()
            const descripcion = $('#descripcion').val()
            let categoria = (document.getElementById("categoria").value === "Panaderia") ? 1 : 2;
            let estado = (document.getElementById("estado").value === "activo") ? 1 : 2;
            const fotoInput = $('#customFile')[0];  // Obtener el elemento DOM del campo de archivo
            const foto = fotoInput.files[0];      
            const formData = new FormData();  // Asegúrate de crear el objeto FormData aquí
            formData.append("id", id);
            formData.append("new_codigo", codigo);
            formData.append("nameProd", nombre);
            formData.append("precio", precio);
            formData.append("descripcion", descripcion);
            formData.append("categoria", categoria);
            formData.append("estado", estado);
            formData.append("foto1", foto);
            $.ajax({
                type: "post",
                url: "editar.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    if (respuesta == 1) {
                        Swal.fire({
                            title: "¡Genial!",
                            text: "Su archivo ha sido editado.",
                            icon: "success"
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.error("Error:", error);
                }
            });
    
}










function datos_producto(id){
    $.ajax({
        type: "post",
        url: "busca_id.php",
        data: {
        id: id
        },
        success: function(respuesta) {
            const producto = JSON.parse(respuesta)
            $('#id').val(producto.id)
            $('#codigo').val(producto.codigo)
            $('#codigo2').val(producto.codigo)
            $('#nameProd').val(producto.nameProd)
            $('#precio').val(producto.precio)
            $('#descripcion').val(producto.description_Prod)
            console.log(respuesta)
        },
    })
    
}


















$(document).ready(function() {
    $("#codigo").on("keyup", function() {
        var codigo = $("#codigo").val();
        var longitudCodigo = $("#codigo").val().length;
        if (longitudCodigo >= 2) {
            $.ajax({
                url: '../dash_board/validar_codigo.php',
                type: "post",
                data: {
                    codigo: codigo
                },
                success: function(datos) {
                    if (datos.success == 1) {
                        var codigo2 = $("#codigo2").val();
                        if(datos.codigo!=codigo2){
                            $("#respuesta").html(datos.message);
                        // Deshabilito el campo de descripción y otros campos
                        $("input#nameProd").attr('disabled', true);
                        $("input#precio").attr('disabled', true);
                        $("textarea#descripcion").attr('disabled', true);
                        $("input#customFile").attr('disabled', true);
                        $("#btonAgg").attr('disabled', true);
                    } 
                        }else {
                            $("#respuesta").html(datos.message);
                            // Habilito el campo de descripción y otros campos
                            $("input#nameProd").attr('disabled', false);
                            $("input#precio").attr('disabled', false);
                            $("textarea#descripcion").attr('disabled', false);
                            $("input#customFile").attr('disabled', false);
                            $("#btonAgg").attr('disabled', false);
                        }
                        
                }
            });
        }
    });



    $("#nameProd").on("keyup", function() {
        var nameProd = $("#nameProd").val();
        var longitudNameProd = $("#nameProd").val().length;
    
        if (longitudNameProd >= 2) {
            $.ajax({
                url: '../dash_board/validar_nomProd.php',
                type: "post",
                data: {
                    nameProd: nameProd  // Cambiado a nameProd para que coincida con el código PHP
                },
                success: function(datos) {
                    if (datos.success == 1) {
                        $("#respuesta2").html(datos.message);
                        $("input#codigo").attr('disabled', true);
                        $("input#precio").attr('disabled', true);
                        $("textarea#decripcion").attr('disabled', true);
                        $("input#customFile").attr('disabled', true);
                        $("#btonAgg").attr('disabled', true);
                    } else {
                        $("#respuesta2").html(datos.message);
                        // Habilito el campo de descripción y otros campos
                        $("input#codigo").attr('disabled', false);
                        $("input#precio").attr('disabled', false);
                        $("textarea#decripcion").attr('disabled', false);
                        $("input#customFile").attr('disabled', false);
                        $("#btonAgg").attr('disabled', false);
                    }
                }
            });
        }
    });
}); 
