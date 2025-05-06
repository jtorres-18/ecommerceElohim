
$(document).ready(function() {
    $("#new_passs").on("keyup", function() {
        var  pass= $("#passs").val();
        var  new_pass= $("#new_passs").val();
        if(new_pass == pass){
            $("#respuesta").html('<p style="color:red;"></p>');
            $("#btn_ingresar").attr('disabled',false);
        }else{
            $("#respuesta").html('<p style="color:red;">las contraseña no coinciden </p>');
            $("#btn_ingresar").attr('disabled',true);
            }
    });

    $("#passs").on("keyup", function() {
        var  pass= $("#passs").val();
        var  new_pass= $("#new_passs").val();
        if(new_pass == pass){
            $("#respuesta").html('<p style="color:red;"></p>');
            $("#btn_ingresar").attr('disabled',false);
        }else{
            $("#respuesta").html('<p style="color:red;">las contraseña no coinciden </p>');
            $("#btn_ingresar").attr('disabled',true);
            }
    });


});