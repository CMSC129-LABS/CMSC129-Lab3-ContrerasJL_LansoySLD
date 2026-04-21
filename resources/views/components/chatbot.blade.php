<div id="upv-chatbot-wrapper">

  <!-- floating bubble -->
  <button id="chat-toggle" aria-label="Open UPV Org Hub Assistant" title="Ask about UPV Orgs">
    <span id="chat-icon-open">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
    </span>
    <span id="chat-icon-close" style="display:none;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </span>
    <span id="chat-notif-dot"></span>
  </button>

    <!-- chat window -->
  <div id="chat-window" aria-label="UPV Org Hub Chatbot" role="dialog">
    <div id="chat-header">
      <div id="chat-header-info">
        <div id="chat-avatar">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
          </svg>
        </div>
        <div>
          <div id="chat-title">OrgBot</div>
          <div id="chat-subtitle">UPV Org Hub Assistant</div>
        </div>
      </div>
      <button id="chat-clear" title="Clear conversation">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/>
        </svg>
      </button>
    </div>

    <div id="chat-messages">
      <div class="msg bot-msg">
        <div class="msg-bubble">
          👋 Hi! I'm <strong>Hubby</strong>, your UPV Org Hub assistant.<br><br>
          Ask me things like:<br>
          <span class="suggestion" data-q="What orgs are currently active?">📋 What orgs are active?</span>
          <span class="suggestion" data-q="Show me performing arts organizations">🎭 Performing arts orgs</span>
          <span class="suggestion" data-q="Which orgs have less than 100 members?">👥 Orgs under 100 members</span>
          <span class="suggestion" data-q="I'm a writer, what org would suit me?">✍️ Orgs for writers</span>
        </div>
      </div>
    </div>

    <div id="chat-typing" style="display:none;">
      <div class="typing-bubble"><span></span><span></span><span></span></div>
    </div>

    <div id="chat-input-area">
      <textarea
        id="chat-input"
        placeholder="Ask about UPV organizations…"
        rows="1"
        maxlength="500"
        aria-label="Chat message input"
      ></textarea>
      <button id="chat-send" aria-label="Send message">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
          <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
        </svg>
      </button>
    </div>
  </div>

</div>

<!-- styles -->
<style>
  :root {
    --upv-maroon: #7b1113;
    --upv-maroon-dark: #5a0c0e;
    --upv-maroon-light: #9e1518;
    --upv-green: #3a7d44;
    --upv-cream: #fdf6ec;
    --upv-cream-dark: #f5eadb;
    --chat-shadow: 0 8px 40px rgba(123,17,19,0.18), 0 2px 12px rgba(0,0,0,0.10);
    --bubble-radius: 18px;
    --font-main: 'Segoe UI', 'Helvetica Neue', sans-serif;
  }

  #upv-chatbot-wrapper { position: fixed; bottom: 28px; right: 28px; z-index: 9999; font-family: var(--font-main); }

  /* toggle */
  #chat-toggle {
    width: 60px; height: 60px; border-radius: 50%;
    background: linear-gradient(135deg, var(--upv-maroon), var(--upv-maroon-dark));
    border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 20px rgba(123,17,19,0.45);
    transition: transform .2s, box-shadow .2s;
    position: relative;
  }
  #chat-toggle:hover { transform: scale(1.08); box-shadow: 0 6px 28px rgba(123,17,19,0.55); }
  #chat-toggle:active { transform: scale(0.96); }

  #chat-notif-dot {
    position: absolute; top: 6px; right: 6px;
    width: 11px; height: 11px; border-radius: 50%;
    background: #f59e0b; border: 2px solid #fff;
    animation: pulse-dot 2s infinite;
  }
  @keyframes pulse-dot { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.3);opacity:.7} }

  /* chat window */
  #chat-window {
    position: absolute; bottom: 74px; right: 0;
    width: 360px; max-height: 540px;
    display: none; flex-direction: column;
    background: #fff; border-radius: 20px;
    box-shadow: var(--chat-shadow);
    overflow: hidden;
    transform-origin: bottom right;
    animation: chat-pop .22s cubic-bezier(.34,1.56,.64,1) forwards;
  }
  #chat-window.open { display: flex; }
  @keyframes chat-pop { from{opacity:0;transform:scale(.85)} to{opacity:1;transform:scale(1)} }

  /*header */
  #chat-header {
    background: linear-gradient(135deg, var(--upv-maroon), var(--upv-maroon-dark));
    padding: 14px 16px; display: flex; align-items: center; justify-content: space-between;
  }
  #chat-header-info { display: flex; align-items: center; gap: 10px; }
  #chat-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.18); display: flex; align-items: center; justify-content: center; color: #fff;
  }
  #chat-title { color: #fff; font-weight: 700; font-size: 15px; line-height: 1.2; }
  #chat-subtitle { color: rgba(255,255,255,.7); font-size: 11px; }
  #chat-clear {
    background: rgba(255,255,255,.15); border: none; border-radius: 8px;
    color: rgba(255,255,255,.8); cursor: pointer; padding: 6px 8px;
    transition: background .15s;
  }
  #chat-clear:hover { background: rgba(255,255,255,.28); }

  /* messages */
  #chat-messages {
    flex: 1; overflow-y: auto; padding: 16px 14px 8px;
    display: flex; flex-direction: column; gap: 10px;
    background: var(--upv-cream);
    scrollbar-width: thin; scrollbar-color: #ddd transparent;
  }
  #chat-messages::-webkit-scrollbar { width: 4px; }
  #chat-messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

  .msg { display: flex; }
  .bot-msg { justify-content: flex-start; }
  .user-msg { justify-content: flex-end; }

  .msg-bubble {
    max-width: 82%; padding: 10px 14px; font-size: 13.5px; line-height: 1.55;
    border-radius: var(--bubble-radius); word-break: break-word;
  }
  .bot-msg .msg-bubble {
    background: #fff; color: #2d1a1b;
    border-bottom-left-radius: 5px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08);
  }
  .user-msg .msg-bubble {
    background: linear-gradient(135deg, var(--upv-maroon), var(--upv-maroon-light));
    color: #fff; border-bottom-right-radius: 5px;
  }

  /* suggestion chips */
  .suggestion {
    display: inline-block; margin: 3px 3px 0 0; padding: 4px 10px;
    background: var(--upv-cream-dark); color: var(--upv-maroon);
    border-radius: 20px; font-size: 12px; cursor: pointer; border: 1px solid #e8d5c0;
    transition: background .15s, transform .1s;
  }
  .suggestion:hover { background: #ecdcc7; transform: translateY(-1px); }

  /* typing indicator */
  #chat-typing { padding: 4px 14px 2px; background: var(--upv-cream); }
  .typing-bubble {
    display: inline-flex; align-items: center; gap: 4px;
    background: #fff; padding: 10px 14px; border-radius: var(--bubble-radius);
    border-bottom-left-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,.08);
  }
  .typing-bubble span {
    width: 7px; height: 7px; border-radius: 50%; background: #ccc;
    animation: bounce 1.2s infinite;
  }
  .typing-bubble span:nth-child(2) { animation-delay: .18s; }
  .typing-bubble span:nth-child(3) { animation-delay: .36s; }
  @keyframes bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-6px)} }

  /* input area */
  #chat-input-area {
    display: flex; align-items: flex-end; gap: 8px;
    padding: 10px 12px; border-top: 1px solid #eee; background: #fff;
  }
  #chat-input {
    flex: 1; border: 1.5px solid #e0d0c0; border-radius: 14px;
    padding: 9px 13px; font-size: 13.5px; font-family: var(--font-main);
    resize: none; outline: none; line-height: 1.4; max-height: 100px;
    transition: border-color .2s;
    background: var(--upv-cream);
  }
  #chat-input:focus { border-color: var(--upv-maroon); background: #fff; }
  #chat-send {
    width: 38px; height: 38px; border-radius: 50%; border: none; cursor: pointer;
    background: linear-gradient(135deg, var(--upv-maroon), var(--upv-maroon-dark));
    color: #fff; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: transform .15s, opacity .15s;
  }
  #chat-send:hover { transform: scale(1.08); }
  #chat-send:disabled { opacity: .45; cursor: not-allowed; transform: none; }

</style>

<!--script-->
<script>
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
      const res = await fetch('{{ route("chatbot.message") }}', {
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
</script>   