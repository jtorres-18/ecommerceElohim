document.addEventListener("DOMContentLoaded", () => {
  // Elementos del DOM
  const chatbotToggle = document.getElementById("chatbot-toggle")
  const chatbotContainer = document.getElementById("chatbot-container")
  const chatbotClose = document.getElementById("chatbot-close")
  const chatbotForm = document.getElementById("chatbot-form")
  const chatbotInput = document.getElementById("chatbot-input")
  const chatbotMessages = document.getElementById("chatbot-messages")
  const optionButtons = document.querySelectorAll(".option-btn")

  // Estado del chatbot
  let isChatbotOpen = false

  // Respuestas predefinidas
  const botResponses = {
    productos:
      "¡Tenemos una gran variedad de productos! Puedes visitar nuestra sección de panadería y repostería. ¿Te gustaría ver alguna categoría específica?",
    horarios: "Nuestro horario de atención es de lunes a sábado de 7:00 AM a 8:00 PM. ¡Te esperamos!",
    ubicacion: "Estamos ubicados en Calle Principal #123, Ciudad. ¿Necesitas indicaciones para llegar?",
    contacto: "Puedes contactarnos al teléfono +57 123 456 7890 o por correo a info@elohim.com",
    pedidos: "Puedes hacer tu pedido directamente en nuestra tienda online o llamando a nuestro número de teléfono.",
    default: "Gracias por tu mensaje. Un miembro de nuestro equipo te responderá pronto.",
  }

  // Opciones de respuesta para diferentes mensajes
  const responseOptions = {
    productos: [
      { text: "Ver panadería", query: "panaderia" },
      { text: "Ver repostería", query: "reposteria" },
      { text: "Productos más vendidos", query: "populares" },
    ],
    horarios: [
      { text: "Hacer un pedido", query: "pedidos" },
      { text: "Ubicación", query: "ubicacion" },
    ],
    ubicacion: [
      { text: "Horarios", query: "horarios" },
      { text: "Contacto", query: "contacto" },
    ],
    panaderia: [
      { text: "Ver todos los productos", query: "productos" },
      { text: "Hacer un pedido", query: "pedidos" },
    ],
    reposteria: [
      { text: "Ver todos los productos", query: "productos" },
      { text: "Hacer un pedido", query: "pedidos" },
    ],
    populares: [
      { text: "Ver todos los productos", query: "productos" },
      { text: "Hacer un pedido", query: "pedidos" },
    ],
    pedidos: [
      { text: "Ver productos", query: "productos" },
      { text: "Contacto", query: "contacto" },
    ],
    contacto: [
      { text: "Horarios", query: "horarios" },
      { text: "Ubicación", query: "ubicacion" },
    ],
    default: [
      { text: "Ver productos", query: "productos" },
      { text: "Horarios", query: "horarios" },
      { text: "Contacto", query: "contacto" },
    ],
  }

  // Respuestas específicas para categorías
  botResponses["panaderia"] =
    "En nuestra sección de panadería encontrarás pan francés, pan integral, croissants, medialunas y mucho más. ¡Todo recién horneado!"
  botResponses["reposteria"] =
    "Nuestra repostería incluye tortas, pasteles, galletas, brownies y muchas delicias más para endulzar tu día."
  botResponses["populares"] =
    "Nuestros productos más vendidos son el pan francés, las medialunas y las tortas de chocolate. ¡Son irresistibles!"

  // Función para abrir/cerrar el chatbot
  function toggleChatbot() {
    isChatbotOpen = !isChatbotOpen
    if (isChatbotOpen) {
      chatbotContainer.classList.add("active")
      // Guardar estado en localStorage
      localStorage.setItem("elohimChatbotOpen", "true")
    } else {
      chatbotContainer.classList.remove("active")
      // Guardar estado en localStorage
      localStorage.setItem("elohimChatbotOpen", "false")
    }
  }

  // Función para añadir un mensaje al chatbot
  function addMessage(message, isUser = false) {
    const messageElement = document.createElement("div")
    messageElement.classList.add("message")
    messageElement.classList.add(isUser ? "user-message" : "bot-message")

    const now = new Date()
    const hours = now.getHours().toString().padStart(2, "0")
    const minutes = now.getMinutes().toString().padStart(2, "0")
    const timeString = `${hours}:${minutes}`

    messageElement.innerHTML = `
            <div class="message-content">
                <p>${message}</p>
            </div>
            <span class="message-time">${timeString}</span>
        `

    chatbotMessages.appendChild(messageElement)

    // Scroll al último mensaje
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight

    return messageElement
  }

  // Función para añadir opciones de respuesta
  function addResponseOptions(query) {
    // Eliminar opciones anteriores si existen
    const existingOptions = chatbotMessages.querySelector(".message-options:last-child")
    if (existingOptions) {
      existingOptions.remove()
    }

    // Determinar qué opciones mostrar
    const options = responseOptions[query] || responseOptions["default"]

    // Crear contenedor de opciones
    const optionsContainer = document.createElement("div")
    optionsContainer.classList.add("message-options")

    // Añadir botones de opciones
    options.forEach((option) => {
      const button = document.createElement("button")
      button.classList.add("option-btn")
      button.textContent = option.text
      button.dataset.query = option.query

      button.addEventListener("click", function () {
        const query = this.dataset.query
        handleUserInput(option.text)
      })

      optionsContainer.appendChild(button)
    })

    chatbotMessages.appendChild(optionsContainer)

    // Scroll al último mensaje
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight
  }

  // Función para procesar la entrada del usuario
  function handleUserInput(input) {
    // Añadir mensaje del usuario
    addMessage(input, true)

    // Simular "escribiendo..."
    setTimeout(() => {
      // Buscar respuesta en las predefinidas o usar la predeterminada
      let response = ""
      let query = ""

      // Convertir input a minúsculas para comparación
      const lowerInput = input.toLowerCase()

      // Buscar coincidencias en palabras clave
      if (lowerInput.includes("producto") || lowerInput.includes("pan") || lowerInput.includes("pastel")) {
        response = botResponses["productos"]
        query = "productos"
      } else if (lowerInput.includes("horario") || lowerInput.includes("abierto") || lowerInput.includes("cerrado")) {
        response = botResponses["horarios"]
        query = "horarios"
      } else if (lowerInput.includes("ubicacion") || lowerInput.includes("direccion") || lowerInput.includes("donde")) {
        response = botResponses["ubicacion"]
        query = "ubicacion"
      } else if (lowerInput.includes("contacto") || lowerInput.includes("telefono") || lowerInput.includes("email")) {
        response = botResponses["contacto"]
        query = "contacto"
      } else if (lowerInput.includes("pedido") || lowerInput.includes("comprar") || lowerInput.includes("ordenar")) {
        response = botResponses["pedidos"]
        query = "pedidos"
      } else if (lowerInput.includes("panaderia")) {
        response = botResponses["panaderia"]
        query = "panaderia"
      } else if (lowerInput.includes("reposteria") || lowerInput.includes("pasteleria")) {
        response = botResponses["reposteria"]
        query = "reposteria"
      } else if (
        lowerInput.includes("popular") ||
        lowerInput.includes("recomendacion") ||
        lowerInput.includes("mejor")
      ) {
        response = botResponses["populares"]
        query = "populares"
      } else {
        // Si no hay coincidencias, usar respuesta predeterminada
        response = botResponses["default"]
        query = "default"
      }

      // Añadir respuesta del bot
      addMessage(response)

      // Añadir opciones de respuesta
      addResponseOptions(query)
    }, 500) // Simular tiempo de respuesta
  }

  // Event Listeners
  chatbotToggle.addEventListener("click", toggleChatbot)
  chatbotClose.addEventListener("click", toggleChatbot)

  chatbotForm.addEventListener("submit", (e) => {
    e.preventDefault()
    const message = chatbotInput.value.trim()
    if (message) {
      handleUserInput(message)
      chatbotInput.value = ""
    }
  })

  // Manejar clics en botones de opciones
  optionButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const query = this.dataset.query
      handleUserInput(this.textContent)
    })
  })

  // Verificar si el chatbot estaba abierto anteriormente
  const chatbotWasOpen = localStorage.getItem("elohimChatbotOpen") === "true"
  if (chatbotWasOpen) {
    toggleChatbot()
  }
})
