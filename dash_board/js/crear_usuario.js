function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function crear_vendedor(e){
    e.preventDefault ();
    const nombre= document.getElementById("nombre").value
    const documento= document.getElementById("documento").value
    const email= document.getElementById("email").value
    const usuario= document.getElementById("usuario").value
    const pass= document.getElementById("pass").value
    if(nombre!= "" && documento!= "" && email!= "" && usuario!="" && pass!= ""){
        if (validarEmail(email)) {
    $.ajax({
        type: "post",
        url: "crear_vendedor.php",
        data: {
        nombre: nombre,
        documento: documento,
        email: email,
        usuario: usuario,
        pass: pass
        },
        success: function(respuesta) {
                if(respuesta==1){
                btnIniciar.click();
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrado con exito',
                        showConfirmButton: false,
                        timer: 2500
                })
                
                }
                if(respuesta==2){
                Swal.fire({
                    icon: 'error',
                    title: 'correo ya existente',
                    showConfirmButton: false,
                    timer: 2500
                })  
                }
                if(respuesta==3){
                    Swal.fire({
                        icon: 'error',
                        title: 'documento ya existente',
                        showConfirmButton: false,
                        timer: 2500
                })  
                }
                if(respuesta==4){
                    Swal.fire({
                        icon: 'error',
                        title: 'usuario ya existente',
                        showConfirmButton: false,
                        timer: 2500
                })  
                }
                
                
        },
    })
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Correo electronico no valido',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }else{
        Swal.fire({
                    icon: 'error',
                    title: 'uno o mas campos estan vacios',
                    showConfirmButton: false,
                    timer: 3000
                })
    }
}


