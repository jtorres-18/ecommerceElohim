document.addEventListener("DOMContentLoaded", () => {
  // Elementos del DOM
  const chatbotToggle = document.getElementById("chatbot-toggle")
  const chatbotContainer = document.getElementById("chatbot-container")
  const chatbotClose = document.getElementById("chatbot-close")
  const chatbotForm = document.getElementById("chatbot-form")
  const chatbotInput = document.getElementById("chatbot-input")
  const chatbotMessages = document.getElementById("chatbot-messages")

  // Estado del chatbot
  let isChatbotOpen = false
  let isTyping = false

  // URL de la API del chatbot (se establece desde chatbot-loader.php)
  const API_URL = window.CHATBOT_API_URL || "api/chat.php"

  // Abrir/cerrar el chatbot
  function toggleChatbot() {
    isChatbotOpen = !isChatbotOpen
    chatbotToggle.classList.toggle("active", isChatbotOpen)
    chatbotContainer.classList.toggle("active", isChatbotOpen)

    // Guardar estado
    localStorage.setItem("elohimChatbotOpen", isChatbotOpen)

    // Enfocar el input al abrir
    if (isChatbotOpen) {
      setTimeout(() => {
        chatbotInput.focus()
      }, 300)
    }
  }

  // Mostrar indicador de "escribiendo"
  function showTypingIndicator() {
    if (isTyping) return

    isTyping = true
    const typingElement = document.createElement("div")
    typingElement.className = "message bot-message typing-indicator"
    typingElement.innerHTML = `
      <span></span>
      <span></span>
      <span></span>
    `
    chatbotMessages.appendChild(typingElement)
    scrollToBottom()
  }

  // Ocultar indicador de "escribiendo"
  function hideTypingIndicator() {
    isTyping = false
    const typingElement = chatbotMessages.querySelector(".typing-indicator")
    if (typingElement) {
      typingElement.remove()
    }
  }

  // Añadir mensaje al chat 
  function addMessage(text, isUser = false, options = null) {
    const messageElement = document.createElement("div")
    messageElement.className = `message ${isUser ? "user-message" : "bot-message"}`

    const timeString = new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })

    messageElement.innerHTML = `
      <div class="message-content">
        <p>${marked.parse(text)}</p>
      </div>
      <span class="message-time">${timeString}</span>
    `

    chatbotMessages.appendChild(messageElement)

    // Añadir opciones si existen
    if (options && !isUser) {
      addResponseOptions(options)
    }

    scrollToBottom()
    return messageElement
  }

  // Añadir opciones de respuesta
  function addResponseOptions(options) {
    const optionsContainer = document.createElement("div")
    optionsContainer.className = "message-options"

    options.forEach((option) => {
      const button = document.createElement("button")
      button.className = "option-btn"
      button.textContent = option
      button.addEventListener("click", () => handleUserInput(option))
      optionsContainer.appendChild(button)
    })

    chatbotMessages.appendChild(optionsContainer)
    scrollToBottom()
  }

  // Desplazarse al final del chat
  function scrollToBottom() {
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight
  }

  // Procesar entrada del usuario
async function handleUserInput(input) {
  // Limpiar y validar input
  const userMessage = input.trim()
  if (!userMessage) return

  // Añadir mensaje del usuario
  addMessage(userMessage, true)

  // Mostrar que el bot está escribiendo
  showTypingIndicator()

  try {
    const usuarioId = sessionStorage.getItem("id_cliente"); // ID del usuario, puedes cambiarlo según tu lógica
    // NUEVA PETICIÓN tipo x-www-form-urlencoded a tu LLM
    const response = await fetch("http://127.0.0.1:8000/llm/v1/elohim", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": "10"
      },
      
      body: JSON.stringify({ query: userMessage, cliente:usuarioId}),
    })

    if (!response.ok) {
      throw new Error(`Error: ${response.status}`)
    }

    const rawText = await response.text()

    let data
    try {
      data = JSON.parse(rawText)
    } catch (e) {
      throw new Error("Error al parsear la respuesta JSON")
    }

    hideTypingIndicator()

    // Mostrar la respuesta del bot
    if (data.response) {
      addMessage(data.response, false, ["Productos", "Horarios", "Ubicación", "Contacto"])
    } else {
      addMessage("Lo siento, ha ocurrido un error. Por favor, intenta de nuevo más tarde.", false)
    }
  } catch (error) {
    console.error("Error al comunicarse con la API:", error)
    hideTypingIndicator()
    
  }
}


  // Respuestas de fallback en caso de error de API
  async function getFallbackResponse(message) {
    const lowerMessage = message.toLowerCase()
    try {
      const response = await fetch("http://127.0.0.1:8000/llm/v1/elohim", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          "Authorization": "10",
        },
        body: new URLSearchParams({ query: lowerMessage, cliente: sessionStorage.getItem("id_cliente") }),
        
      });
  
      if (!response.ok) {
        throw new Error(`Error en la respuesta: ${response.status} ${response.statusText}`);
      }
  
      const respuestaTexto = await response.text();
  
      let data;
      try {
        data = JSON.parse(respuestaTexto);
      } catch (e) {
        throw new Error("Error al parsear la respuesta JSON");
      }
  
      return {
        text: data.response,
        options: ["Productos", "Horarios", "Ubicación", "Contacto"],
      };
    } catch (error) {
      console.error("Ocurrió un error:", error.message);
      return {
        text: "Ocurrió un error al procesar tu solicitud.",
        options: ["Reintentar", "Ayuda", "Inicio"],
      };
    }
  }

  // Event Listeners
  chatbotToggle.addEventListener("click", toggleChatbot)
  chatbotClose.addEventListener("click", toggleChatbot)

  chatbotForm.addEventListener("submit", (e) => {
    e.preventDefault()
    handleUserInput(chatbotInput.value)
    chatbotInput.value = ""
  })

  // Manejar clics fuera del chatbot para cerrarlo
  document.addEventListener("click", (e) => {
    if (isChatbotOpen && !chatbotContainer.contains(e.target) && e.target !== chatbotToggle) {
      toggleChatbot()
    }
  })

  // Cargar estado previo
  if (localStorage.getItem("elohimChatbotOpen") === "true") {
    toggleChatbot()
  }

  // Animación inicial del botón
  setTimeout(() => {
    chatbotToggle.style.transform = "scale(1.1)"
    setTimeout(() => {
      chatbotToggle.style.transform = "scale(1)"
    }, 300)
  }, 1000)
})
