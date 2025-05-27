<?php
/**
 * Chatbot Loader - Sistema para cargar el chatbot en cualquier página
 */

// Obtener la ruta base del chatbot relativa al documento actual
function get_chatbot_base_url() {
    // Si el chatbot está en una subcarpeta 'chatbot' relativa a la raíz del sitio
    $script_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', realpath(__DIR__)));
    return rtrim($script_path, '/');
}

$chatbot_base_url = get_chatbot_base_url();

function include_chatbot() {
    global $chatbot_base_url;
    
    // Incluir el CSS con ruta absoluta
    echo '<link rel="stylesheet" href="' . $chatbot_base_url . '/chatbot.css">';
    
    // Incluir el HTML del chatbot
    ob_start();
    include __DIR__ . '/chatbot-template.php';
    $chatbot_html = ob_get_clean();
    
    // Reemplazar las rutas relativas con rutas absolutas
    $chatbot_html = str_replace('src="chatbot/', 'src="' . $chatbot_base_url . '/', $chatbot_html);
    $chatbot_html = str_replace('href="chatbot/', 'href="' . $chatbot_base_url . '/', $chatbot_html);
    
    // Mostrar el HTML del chatbot
    echo $chatbot_html;
    
    // Incluir el JavaScript con ruta absoluta
    echo '<script src="' . $chatbot_base_url . '/chatbot.js"></script>';
    
    // Inicializar el chatbot
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Establecer la URL base para la API
            window.CHATBOT_API_URL = "' . $chatbot_base_url . '/api/chat.php";
            
            // Establecer la hora actual en el mensaje inicial
            const initialTime = document.getElementById("initial-time");
            if (initialTime) {
                initialTime.textContent = new Date().toLocaleTimeString([], {hour: "2-digit", minute:"2-digit"});
            }
            
            // Configurar los botones de opciones iniciales
            const initialOptions = document.querySelectorAll(".message-options .option-btn");
            initialOptions.forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("chatbot-input").value = this.textContent;
                    document.getElementById("chatbot-form").dispatchEvent(new Event("submit"));
                });
            });
        });
    </script>';
}
?>