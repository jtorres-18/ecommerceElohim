
<div class="elohim-chatbot-widget">
  <button class="chatbot-toggle-btn" id="chatbot-toggle">
    <i class="fas fa-comment-dots"></i>
  </button>

  <div class="chatbot-container" id="chatbot-container">
    <div class="chatbot-header">
      <div class="chatbot-title">
        <img src="https://i.postimg.cc/dtfM2DXJ/Captura-de-pantalla-2025-04-27-125634.png" alt="EloBot" class="chatbot-avatar">
        <h3>EloBot</h3>
        <div class="chatbot-status">
          <span class="status-dot"></span>
          <span>En línea</span>
        </div>
      </div>
      <button class="chatbot-close-btn" id="chatbot-close">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <div class="chatbot-messages" id="chatbot-messages">
      <div class="message bot-message">
        <div class="message-content">
          <p>¡Hola! 👋 Soy EloBot, tu asistente de Panadería Elohim. ¿En qué puedo ayudarte hoy?</p>
        </div>
        <span class="message-time" id="initial-time"></span>
      </div>
      <div class="message-options">
        <button class="option-btn">Productos</button>
        <button class="option-btn">Horarios</button>
        <button class="option-btn">Ubicación</button>
        <button class="option-btn">Contacto</button>
      </div>
    </div>
    
    <div class="chatbot-footer">
      <form id="chatbot-form">
        <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." autocomplete="off">
        <button type="submit" id="chatbot-send">
          <i class="fas fa-paper-plane"></i>
        </button>
      </form>
    </div>
  </div>
</div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>