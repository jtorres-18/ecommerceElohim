
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
                        $("#respuesta").html(datos.message);
                        // Deshabilito el campo de descripción y otros campos
                        $("input#nomProd").attr('disabled', true);
                        $("input#precio").attr('disabled', true);
                        $("textarea#decripcion").attr('disabled', true);
                        $("input#customFile").attr('disabled', true);
                        $("#btonAgg").attr('disabled', true);
                    } else {
                        $("#respuesta").html(datos.message);
                        // Habilito el campo de descripción y otros campos
                        $("input#nomProd").attr('disabled', false);
                        $("input#precio").attr('disabled', false);
                        $("textarea#decripcion").attr('disabled', false);
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
