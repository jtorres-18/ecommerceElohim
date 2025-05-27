<?php
/**
 * Base de datos de respuestas del chatbot
 * 
 * Este archivo contiene todas las respuestas predefinidas del chatbot
 */

// Respuestas predefinidas
$botResponses = [
    'bienvenida' => [
        'text' => "¡Hola! 👋 Soy EloBot, tu asistente virtual de Panadería Elohim. ¿En qué puedo ayudarte hoy?",
        'options' => ["Productos", "Horarios", "Ubicación", "Contacto"]
    ],
    'productos' => [
        'text' => "¡Tenemos una gran variedad de productos artesanales! 🥖🍰 Puedes elegir entre:",
        'options' => ["Panadería tradicional", "Repostería fina", "Productos especiales", "Promociones"]
    ],
    'panaderia' => [
        'text' => "Nuestra panadería incluye: pan francés ($2.500), pan integral ($3.000), baguettes ($2.800), pan de queso ($3.200) y más. Todo horneado diariamente con ingredientes naturales.",
        'options' => ["Ver repostería", "Promociones", "Hacer pedido", "Horarios"]
    ],
    'reposteria' => [
        'text' => "En repostería ofrecemos: tortas personalizadas (desde $25.000), cupcakes ($3.500 c/u), galletas decoradas ($1.500 c/u), brownies ($2.800) y postres caseros. ¡Perfectos para ocasiones especiales!",
        'options' => ["Ver panadería", "Promociones", "Hacer pedido", "Contacto"]
    ],
    'promociones' => [
        'text' => "📢 ¡Promociones de la semana! 🎉<br>- 2 panes franceses + 1 café: $5.000<br>- Docena de medialunas: $12.000<br>- Torta pequeña + 6 cupcakes: $30.000",
        'options' => ["Panadería", "Repostería", "Hacer pedido", "Contacto"]
    ],
    'horarios' => [
        'text' => "⏰ Horario de atención:<br>Lunes a Viernes: 7:00 AM - 8:00 PM<br>Sábados: 7:00 AM - 6:00 PM<br>Domingos: 8:00 AM - 2:00 PM",
        'options' => ["Ubicación", "Contacto", "Productos", "Hacer pedido"]
    ],
    'ubicacion' => [
        'text' => "📍 Estamos en:<br>Carrera 5 #49-00, Puerto Berrío, Antioquia<br><a href='https://maps.google.com' target='_blank' style='color: #e67e22;'>Ver en mapa</a>",
        'options' => ["Horarios", "Contacto", "Productos", "Hacer pedido"]
    ],
    'contacto' => [
        'text' => "📞 Contáctanos:<br>Teléfono: +57 123 456 7890<br>WhatsApp: +57 123 456 7890<br>Email: info@panaderiaelohim.com",
        'options' => ["Horarios", "Ubicación", "Productos", "Hacer pedido"]
    ],
    'pedidos' => [
        'text' => "Para hacer pedidos puedes:<br>1. Llamarnos directamente<br>2. Escribirnos por WhatsApp<br>3. Visitar nuestra tienda física<br>¿Quieres que te ayude con algo más?",
        'options' => ["Productos", "Horarios", "Ubicación", "Contacto"]
    ],
    'delivery' => [
        'text' => "🚚 Servicio a domicilio disponible en Puerto Berrío con un costo adicional de $3.000. Pedidos mínimos de $15.000.",
        'options' => ["Hacer pedido", "Productos", "Horarios", "Contacto"]
    ],
    'default' => [
        'text' => "Disculpa, no entendí tu consulta. ¿Podrías reformularla? Estoy aquí para ayudarte con información sobre productos, horarios, ubicación o pedidos.",
        'options' => ["Productos", "Horarios", "Ubicación", "Contacto"]
    ]
];

// Mapeo de palabras clave a respuestas
$keywordMap = [
    // Productos
    'producto|productos|pan|panes|reposteria|dulce|torta|galleta' => 'productos',
    'panaderia|panes|baguette|integral|frances|queso' => 'panaderia',
    'reposteria|torta|pastel|cupcake|galleta|brownie|dulce|postre' => 'reposteria',
    'promocion|oferta|descuento|combo' => 'promociones',
    
    // Información
    'hora|horario|abierto|cerrado|atencion' => 'horarios',
    'ubicacion|direccion|donde|mapa|llegar' => 'ubicacion',
    'contacto|telefono|whatsapp|email|correo' => 'contacto',
    
    // Servicios
    'pedido|ordenar|comprar|reservar|encargar' => 'pedidos',
    'domicilio|delivery|envio|llevar' => 'delivery',
    
    // Saludos
    'hola|buenas|saludos|hey|hi' => 'bienvenida'
];

/**
 * Obtiene la respuesta adecuada basada en el mensaje del usuario
 * 
 * @param string $message Mensaje del usuario
 * @return array Respuesta con texto y opciones
 */
function getResponse($message) {
    global $botResponses, $keywordMap;
    
    // Convertir mensaje a minúsculas para comparación
    $lowerMessage = strtolower($message);
    
    // Buscar coincidencia con palabras clave
    foreach ($keywordMap as $keywords => $responseKey) {
        $keywordArray = explode('|', $keywords);
        foreach ($keywordArray as $keyword) {
            if (strpos($lowerMessage, $keyword) !== false) {
                return $botResponses[$responseKey];
            }
        }
    }
    
    // Si no hay coincidencia, devolver respuesta por defecto
    return $botResponses['default'];
}
