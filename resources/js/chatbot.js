(function () {
  const wrapper        = document.getElementById('upv-chatbot-wrapper');
  const chatUrl        = wrapper?.dataset.url;
  const executeUrl     = wrapper?.dataset.executeUrl;
  const window_el      = document.getElementById('chat-window');
  const toggle         = document.getElementById('chat-toggle');
  const notifDot       = document.getElementById('chat-notif-dot');  // may be null
  const messages       = document.getElementById('chat-messages');
  const typingEl       = document.getElementById('chat-typing');
  const input          = document.getElementById('chat-input');
  const sendBtn        = document.getElementById('chat-send');
  const clearBtn       = document.getElementById('chat-clear');
  const crudToggle     = document.getElementById('crud-toggle-input');
  const crudBanner     = document.getElementById('crud-banner');
  const confirmOverlay = document.getElementById('crud-confirm-overlay');
  const confirmText    = document.getElementById('crud-confirm-text');
  const confirmOk      = document.getElementById('crud-ok-btn');
  const confirmCancel  = document.getElementById('crud-cancel-btn');

  let isLoading   = false;
  let crudMode    = false;
  let pendingCrud = null;
  let history     = [];
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  // ── open/close chat window ──
  toggle?.addEventListener('click', () => {
    const isOpen = window_el.classList.toggle('open');
    const label = document.getElementById('chat-toggle-label');
    if (label) label.textContent = isOpen ? 'close' : 'ask hubby';
    if (isOpen) { if (notifDot) notifDot.style.display = 'none'; input?.focus(); }
  });

  // ── CRUD mode toggle ──
  crudToggle?.addEventListener('change', () => {
    crudMode = crudToggle.checked;
    crudBanner.style.display = crudMode ? 'flex' : 'none';
    input.placeholder = crudMode
      ? 'Add, update, or archive orgs…'
      : 'Ask about UPV organizations…';
    appendMsg('bot', crudMode
      ? '⚡ crud mode on baby! now you can add, update, or archive orgs. just tell me what to do~'
      : '🔍 back to query mode! ask me anything about the orgs 😊'
    );
  });

  // ── clear history ──
  clearBtn?.addEventListener('click', () => {
    history = [];
    messages.innerHTML = `
      <div class="msg bot-msg">
        <div class="msg-bubble">🧹 cleared! what do you want to know, baby?</div>
      </div>`;
  });

  // ── suggestion chips ──
  messages?.addEventListener('click', (e) => {
    if (e.target.classList.contains('suggestion')) {
      input.value = e.target.dataset.q;
      sendMessage();
    }
  });

  // ── send on Enter ──
  input?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  });
  sendBtn?.addEventListener('click', sendMessage);

  // ── auto-resize textarea ──
  input?.addEventListener('input', () => {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 100) + 'px';
  });

  // ── confirm dialog buttons ──
  confirmOk?.addEventListener('click', async () => {
    if (!pendingCrud) return;
    confirmOverlay.style.display = 'none';
    await executeCrudAction(pendingCrud.action, pendingCrud.data);
    pendingCrud = null;
  });

  confirmCancel?.addEventListener('click', () => {
    confirmOverlay.style.display = 'none';
    pendingCrud = null;
    appendMsg('bot', 'okay cancelled baby! anything else? 😊');
  });

  // ── main send ──
  async function sendMessage() {
    const text = input.value.trim();
    if (!text || isLoading) return;

    input.value = '';
    input.style.height = 'auto';
    if (notifDot) notifDot.style.display = 'none';

    appendMsg('user', escapeHtml(text));
    history.push({ role: 'user', content: text });
    setLoading(true);

    try {
      const res = await fetch(chatUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          message:   text,
          history:   history.slice(-10),
          crud_mode: crudMode,
        }),
      });

      const data = await res.json();
      setLoading(false);

      if (data.error) {
        // backend returns error (rate limit)
        appendMsg('bot', "hmm, something went wrong on my end baby. try again in a bit! 🙏");
        return;
      }

      // ── CRUD action detected ──
      if (crudMode && data.crud_action) {
        appendMsg('bot', formatBotText(data.reply));
        history.push({ role: 'model', content: data.reply });

        if (data.requires_confirm) {
          // UPDATE or ARCHIVE — show confirm dialog
          const label = data.crud_action === 'ARCHIVE'
            ? `archive "${data.crud_data?.name || 'this org'}"`
            : `update "${data.crud_data?.name || 'this org'}"`;
          confirmText.textContent = `are you sure you want to ${label}? 👀`;
          confirmOverlay.style.display = 'flex';
          pendingCrud = { action: data.crud_action, data: data.crud_data };
        } else {
          // CREATE — no confirm needed, execute right away
          await executeCrudAction(data.crud_action, data.crud_data);
        }
        return;
      }

      // ── normal query response ──
      const botText = data.reply || "i couldn't find an answer baby, try rephrasing?";
      appendMsg('bot', formatBotText(botText));
      history.push({ role: 'model', content: botText });

    } catch (err) {
      setLoading(false);
      // network error
      appendMsg('bot', '⚠️ network error baby, check your connection!');
      console.error(err);
    }
  }

  // ── execute CRUD via /chatbot/execute ──
  async function executeCrudAction(action, data) {
    setLoading(true);
    try {
      const res = await fetch(executeUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ action, data }),
      });

      const result = await res.json();
      setLoading(false);

      if (result.success) {
        let msg = '';
        if (action === 'CREATE') {
            const orgName = result.org?.name ?? 'the org';
            msg = `✅ done baby! **${orgName}** has been created~\n\n📸 *note: to add a cover photo or logo, go to the org list and edit it manually!*`;
        } else if (action === 'UPDATE') {
            const orgName = result.org?.name ?? 'the org';
            msg = `✅ updated **${orgName}** successfully baby!\n\n📸 *to change the photo, edit it manually from the org list!*`;
        } else if (action === 'ARCHIVE') {
            // extract name from message string e.g. "'dog lovers org' has been archived."
            const orgName = result.message?.match(/'(.+?)'/)?.[1] ?? 'the org';
            msg = `🗑️ **${orgName}** has been archived baby! it's in the archives now~`;
        }
        appendMsg('bot', formatBotText(msg));
        history.push({ role: 'model', content: msg });

        // refresh page after short delay so org list updates
        setTimeout(() => window.location.reload(), 1000);

      } else {
        // appendMsg('bot', ⚠️ failed baby: ${result.message || 'something went wrong'});
        appendMsg('bot', "oops, i wasn't able to do that baby. try again or do it manually! 😊");
      }

    } catch (err) {
      setLoading(false);
      appendMsg('bot', '⚠️ crud failed baby, try again!');
      console.error(err);
    }
  }

  // ── helpers ──
  function appendMsg(role, html) {
    const div = document.createElement('div');
    div.className = `msg ${role === 'user' ? 'user-msg' : 'bot-msg'}`;
    div.innerHTML = `<div class="msg-bubble">${html}</div>`;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
    return div;
  }

  function formatBotText(text) {
    return text
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\*(.*?)\*/g, '<em>$1</em>')
      .replace(/^- (.+)/gm, '• $1')
      .replace(/\n/g, '<br>');
  }

  function setLoading(state) {
    isLoading        = state;
    sendBtn.disabled = state;
    input.disabled   = state;
    typingEl.style.display = state ? 'block' : 'none';
    if (state) messages.scrollTop = messages.scrollHeight;
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

})();
