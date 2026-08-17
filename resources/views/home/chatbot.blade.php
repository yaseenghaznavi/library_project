<!-- 🟨 Chatbot Container -->
<style>
    #chatbot-container {
        position: fixed;
        right: 25px;
        bottom: 25px;
        z-index: 9999;
    }

    #chatbot-toggle {
        width: 60px;
        height: 60px;
        border: none;
        border-radius: 50%;
        background: #6c4cff;
        color: white;
        font-size: 25px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    #chatbot-box {
        display: grid;
        grid-template-rows: auto 1fr auto;
    }

    #chatbot-box.hidden {
        display: none;
    }

    #chatbot-header {
        background: #6c4cff;
        color: white;
        padding: 15px;
        font-weight: bold;
    }

    #chatbot-messages {
        overflow-y: auto;
        padding: 15px;
        color: #333 !important;
        min-height: 0;
    }

    #chatbot-messages p {
        display: block !important;
        visibility: visible !important;
        color: #333 !important;
        margin: 8px 0;
    }

    #chatbot-input-area {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ddd;
        gap: 8px;
    }

    #chatbot-input {
        flex: 1;
        padding: 9px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    #chatbot-send {
        border: none;
        background: #6c4cff;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">

    <!-- 🟨 Floating Chat Button -->
    <button
        type="button"
        id="chatbot-toggle">
        💬
    </button>

    <!-- 🟨 Chat Window -->
    <div
        id="chatbot-box"
        class="hidden w-80 h-96 bg-white rounded-lg shadow-xl mt-3 flex flex-col border">

        <!-- 🟨 Header -->
        <div id="chatbot-header">
            Library Assistant
        </div>

        <!-- 🟨 Messages -->
        <div
            id="chatbot-messages"
            class="flex-1 p-3 overflow-y-auto text-sm">

            <p>
                <strong>Bot:</strong>
                Hello! How can I help you?
            </p>

        </div>

        <!-- 🟨 Input Area -->
        <div id="chatbot-input-area">

            <input
                id="chatbot-input"
                type="text"
                placeholder="Ask something..."
                class="flex-1 border rounded px-2 py-1">

            <button
                type="button"
                id="chatbot-send">
                Send
            </button>

        </div>

    </div>
</div>


<!-- 🟨 Chatbot JavaScript -->
<script>
    const toggle = document.getElementById('chatbot-toggle');
    const box = document.getElementById('chatbot-box');
    const send = document.getElementById('chatbot-send');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    // 🟨 Open / close chatbot
    toggle.addEventListener('click', function () {
        box.classList.toggle('hidden');
    });

    // 🟨 Send message
    send.addEventListener('click', function(event) {
        event.preventDefault();
        sendMessage();
    });

    // 🟨 Allow Enter key
    input.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    // 🟨 Dummy chatbot response for now
    function sendMessage() {
        const message = input.value.trim();

        if (!message) {
            return;
        }

        fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const botMessage = document.createElement('p');
            botMessage.innerHTML = `<strong>Bot:</strong> ${data.message}`;
            console.log(messages);
            console.log(messages.innerHTML);
            messages.appendChild(botMessage);
            console.log(messages.innerHTML);

            messages.scrollTop = messages.scrollHeight;
            
        });
    }
</script>