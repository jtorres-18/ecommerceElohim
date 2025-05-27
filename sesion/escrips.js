const   btnIniciar = document.getElementById("iniciar"),
        btnVolver = document.getElementById("volver");
        btnRecUse = document.getElementById("custom-button1"),
        btnRecCont = document.getElementById("custom-button2");
        formRegister = document.querySelector(".register"),
        formlogin = document.querySelector(".login");
        formRecUse = document.querySelector(".recUse"),
        formRecCont = document.querySelector(".recCont");

btnIniciar.addEventListener("click", e =>{
    formRegister.classList.add("hide");
    formlogin.classList.remove("hide");
})

btnVolver.addEventListener("click", e =>{
    formlogin.classList.add("hide");
    formRegister.classList.remove("hide");
})

btnRecUse.addEventListener("click", e =>{
    formlogin.classList.add("hide");
    formRegister.classList.add("hide");
    formRecCont.classList.add("hide");
    formRecUse.classList.remove("hide");
})

btnRecCont.addEventListener("click", e =>{
    formlogin.classList.add("hide");
    formRegister.classList.add("hide");
    formRecUse.classList.add("hide");
    formRecCont.classList.remove("hide");
    
})

function regresarAlInicio() {
    // Ocultar formulario de recuperar usuario
    document.querySelector('.contenedor-formulario.recUse').classList.add('hide');

    // Ocultar formulario de recuperar contraseña
    document.querySelector('.contenedor-formulario.recCont').classList.add('hide');

    // Mostrar formulario de inicio de sesión
    document.querySelector('.contenedor-formulario.login').classList.remove('hide');
}


function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}



function registrarse(e){
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
        url: "formulario.php",
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


function logueo(e){
    e.preventDefault ();
    const usuario= document.getElementById("user").value
    const pass= document.getElementById("password").value
if(usuario!= "" && pass!= ""){
    $.ajax({
        type: "post",
        url: "iniciar_sesion.php",
        data: {
        usuario: usuario,
        pass: pass
        },
        success: function(respuesta) {
          const data = JSON.parse(respuesta);
      
          if (data.success) {
              sessionStorage.setItem("id_cliente", data.id);
              localStorage.setItem("id_cliente", data.id);
              sessionStorage.setItem("tipo_usuario", data.tipo_usuario);
      
              if (data.tipo_usuario == 1) {
                  window.location.href = "../mostrar/productos.php";
              } else if (data.tipo_usuario == 2) {
                  window.location.href = "../dash_board/index.php";
              } else if (data.tipo_usuario == 3) {
                  window.location.href = "../dash_board/index_vendor.php";
              }
          } else {
              Swal.fire({
                  icon: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 3000
              }); 
                }
        },
    })
    
    }else{
        Swal.fire({
                    icon: 'error',
                    title: 'campos incompletos',
                    showConfirmButton: false,
                    timer: 3000
                })
    }
}

function enviar_correo(email, subject){
    $.ajax({
        type: "post",
        url: "../enviar_prueba/enviar.php",
        data: {
        email: email,
        subject: subject
        },
        success: function(respuesta) {
        console.log(respuesta)
        }
    })
}

// Asegúrate de incluir jQuery y SweetAlert2 antes de este script

function recuperar_usuario(e) {
    e.preventDefault();
  
    const documento = $('#identidad').val().trim();
    const pass      = $('#pas').val().trim();
  
    if (!documento || !pass) {
      Swal.fire({
        icon: 'error',
        title: 'Campos incompletos',
        text: 'Por favor ingresa documento y contraseña',
        timer: 3000,
        showConfirmButton: false
      });
      return;
    }
  
    $.ajax({
      type: 'POST',
      url: 'recupar_usuario.php',
      dataType: 'json',
      data: { documento, pass },
      success: function(res) {
        if (res.status === 'success') {
          // Construye el HTML del correo
          const html = `
            <!DOCTYPE html>
            <html>
            <head>
              <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width:600px; margin:0 auto; padding:20px; background:#f4f4f4; }
                .logo { text-align:center; }
                .logo img { max-width:200px; }
              </style>
            </head>
            <body>
              <div class="container">
                <div class="logo">
                  <img src="https://i.postimg.cc/nrGQ8SSX/logo.png" alt="Logo">
                </div>
                <h1>Nombre de Usuario Olvidado</h1>
                <p>Hola ${res.nombre},</p>
                <p>Tu nombre de usuario es:</p>
                <p><strong>${res.usuario}</strong></p>
                <p>Si no solicitaste esto, ignora este correo.</p>
                <p>Gracias, elohim</p>
              </div>
            </body>
            </html>
          `;
          // Llama a tu función de envío
          enviar_correo(res.correo, html);
  
          Swal.fire({
            icon: 'success',
            title: `Información enviada a ${res.correo}`,
            confirmButtonText: 'OK'
          }).then(() => {
            window.location.href = 'login.html';
          });
        } else {
          // warning o error
          Swal.fire({
            icon: res.status === 'warning' ? 'info' : 'error',
            title: res.message,
            timer: 3000,
            showConfirmButton: false
          });
        }
      },
      error: function(xhr, status, err) {
        console.error(xhr.status, err, xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: `Error ${xhr.status}`,
          text: 'No se pudo procesar la solicitud',
          timer: 3000,
          showConfirmButton: false
        });
      }
    });
  }
  

  function nueva_contra(e) {
    e.preventDefault();
  
    const id        = document.getElementById("id").value.trim();
    const newPass   = document.getElementById("new_passs").value.trim();
  
    if (!newPass) {
      Swal.fire({
        icon: 'error',
        title: 'Debe ingresar la nueva contraseña',
        timer: 2500,
        showConfirmButton: false
      });
      return;
    }
  
    $.ajax({
      type:     "POST",
      url:      "consulta.php",     // asegúrate de que este sea el path correcto
      dataType: "text",             // vamos a recibir un plain-text "1" o "2"
      data: {
        id:       id,
        new_pass: newPass           // clave nueva: 'new_pass' (no 'new_passs')
      },
      success: function(respuesta) {
        console.log("respuesta AJAX:", respuesta);
        respuesta = respuesta.trim(); // quitar espacios o saltos de línea
  
        if (respuesta === "1") {
          Swal.fire({
            icon: 'success',
            title: 'Contraseña restaurada con éxito',
            timer: 2500,
            showConfirmButton: false
          }).then(() => {
            window.location.href = 'login.html';
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'No se pudo cambiar la contraseña',
            text: 'Respuesta del servidor: ' + respuesta,
            timer: 3000,
            showConfirmButton: false
          });
        }
      },
      error: function(xhr, status, error) {
        console.error("Error AJAX:", status, error, "\nResponse:", xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error de conexión',
          text: `HTTP ${xhr.status}`,
          timer: 3000,
          showConfirmButton: false
        });
      }
    });
  }
  
  


function recuperar_pass(e) {
    e.preventDefault();
  
    const email = $('#correo').val().trim();
  
    if (!email) {
      return Swal.fire({
        icon: 'error',
        title: 'Campos incompletos',
        text:  'Por favor ingresa tu correo',
        timer: 3000,
        showConfirmButton: false
      });
    }
  
    if (!validarEmail(email)) {
      return Swal.fire({
        icon: 'error',
        title: 'Correo inválido',
        text:  'Por favor ingresa un correo válido',
        timer: 3000,
        showConfirmButton: false
      });
    }
  
    $.ajax({
      type:     'POST',
      url:      'recuperar_contraseña.php',
      dataType: 'json',
      data:     { correo: email },
      success: function(res) {
        // Respuesta esperada: { status: 'success'|'warning'|'error', message: '...', data: {...} }
        if (res.status === 'success') {
          const u = res.data; // { id, nombre, correo }
  
          // Construyo el HTML del email
          const html = `
            <!DOCTYPE html>
            <html>
            <head><meta charset="utf-8"><title>Recuperación de Contraseña</title>
              <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width:600px; margin:0 auto; padding:20px; }
                .header { text-align:center; }
                .header img { max-width:150px; }
                .content { background:#f9f9f9; padding:20px; border-radius:5px; }
                .button { display:inline-block; background:#4CAF50; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px; }
              </style>
            </head>
            <body>
              <div class="container">
                <div class="header">
                  <img src="https://i.postimg.cc/nrGQ8SSX/logo.png" alt="Logo">
                  <h2>Recuperación de Contraseña</h2>
                </div>
                <div class="content">
                  <p>¡Hola ${u.nombre}!</p>
                  <p>Para restablecer tu contraseña haz clic en el siguiente enlace:</p>
                  <p style="text-align:center;">
                    <a href="http://localhost/panaderia/sesion/contra.php?id=${u.id}" class="button">Restablecer Contraseña</a>
                  </p>
                  <p>Si no solicitaste este cambio, ignora este correo.</p>
                </div>
              </div>
            </body>
            </html>
          `;
  
          enviar_correo(u.correo, html);
  
          Swal.fire({
            icon: 'success',
            title: `Te enviamos un enlace a ${u.correo}`,
            confirmButtonText: 'OK'
          }).then(() => {
            window.location.href = 'login.html';
          });
  
        } else {
          // warning o error
          Swal.fire({
            icon: res.status === 'warning' ? 'info' : 'error',
            title: res.message,
            timer: 3000,
            showConfirmButton: false
          });
        }
      },
      error: function(xhr, status, err) {
        console.error('AJAX Error:', xhr.status, err, xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: `Error ${xhr.status}`,
          text: 'No se pudo procesar la solicitud',
          timer: 3000,
          showConfirmButton: false
        });
      }
    });
  }
  






