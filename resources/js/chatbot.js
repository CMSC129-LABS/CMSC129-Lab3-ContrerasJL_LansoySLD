
(function () {
  const toggle      = document.getElementById('chat-toggle');
  const window_el   = document.getElementById('chat-window');
  const iconOpen    = document.getElementById('chat-icon-open');
  const iconClose   = document.getElementById('chat-icon-close');
  const notifDot    = document.getElementById('chat-notif-dot');
  const messages    = document.getElementById('chat-messages');
  const typingEl    = document.getElementById('chat-typing');
  const input       = document.getElementById('chat-input');
  const sendBtn     = document.getElementById('chat-send');
  const clearBtn    = document.getElementById('chat-clear');

  let isOpen = false;
  let history = []; // [{role, content}]
  let isLoading = false;

  // toggle open/close
  toggle.addEventListener('click', () => {
    isOpen = !isOpen;
    window_el.classList.toggle('open', isOpen);
    iconOpen.style.display  = isOpen ? 'none'  : 'flex';
    iconClose.style.display = isOpen ? 'flex'  : 'none';
    notifDot.style.display  = isOpen ? 'none'  : '';
    if (isOpen) { setTimeout(() => input.focus(), 180); }
  });

  // clear history
  clearBtn.addEventListener('click', () => {
    history = [];
    messages.innerHTML = `
      <div class="msg bot-msg">
        <div class="msg-bubble">
          Chat cleared! Ask me anything about UPV organizations. 😊
        </div>
      </div>`;
  });

  // suggestion chips
  messages.addEventListener('click', (e) => {
    if (e.target.classList.contains('suggestion')) {
      input.value = e.target.dataset.q;
      sendMessage();
    }
  });

  // Send on Enter (Shift+Enter = newline) 
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  });
  sendBtn.addEventListener('click', sendMessage);

  // Auto-resize textarea
  input.addEventListener('input', () => {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 100) + 'px';
  });

  function appendMsg(role, html) {
    const div = document.createElement('div');
    div.className = `msg ${role === 'user' ? 'user-msg' : 'bot-msg'}`;
    div.innerHTML = `<div class="msg-bubble">${html}</div>`;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
    return div;
  }

  function setLoading(state) {
    isLoading = state;
    sendBtn.disabled = state;
    input.disabled   = state;
    typingEl.style.display = state ? 'block' : 'none';
    if (state) messages.scrollTop = messages.scrollHeight;
  }

  function formatBotText(text) {
    // Basic markdown-ish formatting
    return text
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\*(.*?)\*/g, '<em>$1</em>')
      .replace(/\n/g, '<br>');
  }

  async function sendMessage() {
    const text = input.value.trim();
    if (!text || isLoading) return;

    input.value = '';
    input.style.height = 'auto';
    notifDot.style.display = 'none';

    appendMsg('user', escapeHtml(text));
    history.push({ role: 'user', content: text });
    setLoading(true);

    try {
        const url = document.getElementById('upv-chatbot-wrapper').dataset.url;
        const res = await fetch(url, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ message: text, history: history.slice(-10) }),
      });

      const data = await res.json();
      setLoading(false);

      if (data.error) {
        appendMsg('bot', '⚠️ Error: ' + JSON.stringify(data));  // show full error
        return;
        }

      const botText = data.reply || 'I couldn\'t find an answer. Try rephrasing?';
      appendMsg('bot', formatBotText(botText));
      history.push({ role: 'model', content: botText });

    } catch (err) {
      setLoading(false);
      appendMsg('bot', '⚠️ Network error. Please check your connection.' + JSON.stringify(data));
    }
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
})();
