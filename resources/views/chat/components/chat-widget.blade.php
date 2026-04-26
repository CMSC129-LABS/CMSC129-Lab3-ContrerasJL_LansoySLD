<div id="upv-chatbot-wrapper" data-url="{{ route('chatbot.message') }}" data-execute-url="{{ route('chatbot.execute') }}">

    <!-- chat window (toggle button lives in the navbar) -->
    <div id="chat-window" aria-label="UPV Org Hub Chatbot" role="dialog">

        <!-- header -->
        <div id="chat-header">
            <div id="chat-header-info">
                <div id="chat-avatar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" />
                    </svg>
                </div>
                <div>
                    <div id="chat-title">OrgBot</div>
                    <div id="chat-subtitle">UPV Org Hub Assistant</div>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:8px;">
                <!-- CRUD MODE TOGGLE -->
                <div id="crud-toggle-wrap" title="Toggle CRUD mode">
                    <span id="crud-toggle-label">query</span>
                    <label class="crud-switch">
                        <input type="checkbox" id="crud-toggle-input">
                        <span class="crud-slider"></span>
                    </label>
                    <span id="crud-toggle-label2">crud</span>
                </div>

                <button id="chat-clear" title="Clear conversation">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10" />
                        <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- CRUD mode banner -->
        <div id="crud-banner" style="display:none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            CRUD mode on — you can add, update, or archive orgs!
        </div>

        <!-- messages -->
        <div id="chat-messages">
            {{-- <div class="msg bot-msg">
                <div class="msg-bubble">
                    👋 Hi! I'm <strong>Hubby</strong>, your UPV Org Hub assistant.<br><br>
                    Ask me things like:<br>
                    <span class="suggestion" data-q="What orgs are currently active?">📋 What orgs are active?</span>
                    <span class="suggestion" data-q="Show me performing arts organizations">🎭 Performing arts orgs</span>
                    <span class="suggestion" data-q="Which orgs have less than 100 members?">👥 Orgs under 100 members</span>
                    <span class="suggestion" data-q="I'm a writer, what org would suit me?">✍️ Orgs for writers</span>
                </div>
            </div> --}}
        </div>

        <div id="chat-typing" style="display:none;">
            <div class="typing-bubble"><span></span><span></span><span></span></div>
        </div>

        <!-- confirm dialog -->
        <div id="crud-confirm-overlay" style="display:none;">
            <div id="crud-confirm-box">
                <p id="crud-confirm-title">⚠️ confirm action</p>
                <p id="crud-confirm-text"></p>
                <div id="crud-confirm-btns">
                    <button id="crud-cancel-btn">cancel</button>
                    <button id="crud-ok-btn">yes, do it!</button>
                </div>
            </div>
        </div>

        <!-- input -->
        <div id="chat-input-area">
            <textarea id="chat-input" placeholder="Ask about UPV organizations…" rows="1" maxlength="500"
                aria-label="Chat message input"></textarea>
            <button id="chat-send" aria-label="Send message">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/chatbot.js') }}"></script>
