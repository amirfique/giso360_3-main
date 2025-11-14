<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced AI Chatbot</title>
    <!-- CSRF Token (you'll need to add this in your Laravel layout) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    

    <style>
        :root {
            --primary-color: #774dd3;
            --primary-light: #e8f0fe;
            --bot-bubble: #f7fafc;
            --user-bubble: ##774dd3;
            --shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        /* Floating Button */
        #chatbot-toggler {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #chatbot-toggler:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(94, 114, 228, 0.3);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 15px 20px;
        }

        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Noto Sans', sans-serif;
        }

        .modal-title i {
            font-size: 1.2rem;
        }

        .modal-body {
            padding: 0;
            background-color: #f8f9fe;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px;
            background-color: white;
        }

        /* Chat History */
        #chat-history {
            height: 400px;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fe;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Chat Bubbles */
        .chat-bubble {
            padding: 12px 16px;
            border-radius: var(--radius);
            margin-bottom: 8px;
            max-width: 80%;
            position: relative;
            animation: fadeIn 0.3s ease;
            word-wrap: break-word;
            line-height: 1.4;
            font-family: 'Open Sans', sans-serif;
            font-size: 0.9rem;
            box-shadow: var(--shadow);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chat-bubble.bot {
            background-color: var(--bot-bubble);
            color: #525f7f;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            border: 1px solid #e9ecef;
        }

        .chat-bubble.user {
            background-color: var(--user-bubble);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .chat-bubble.loading {
            background-color: var(--bot-bubble);
            color: #8898aa;
            align-self: flex-start;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #e9ecef;
        }

        .typing-indicator {
            display: inline-flex;
            gap: 4px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #8898aa;
            animation: typingAnimation 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }

        /* Input Area */
        .input-group {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        #chat-input {
            border-radius: 8px;
            padding: 10px 16px;
            border: 1px solid #cad1d7;
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition);
        }

        #chat-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 1px 3px rgba(50, 50, 93, 0.15), 0 1px 0 rgba(0, 0, 0, 0.02);
        }

        #send-chat-btn {
            border-radius: 8px;
            margin-left: 8px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 6px;
            background-color: var(--primary-color);
            border: none;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 600;
        }

        #send-chat-btn:hover {
            background-color: #4a5cd4;
            transform: translateY(-1px);
        }

        /* Welcome Message */
        .welcome-message {
            text-align: center;
            padding: 20px;
            color: #8898aa;
            font-family: 'Open Sans', sans-serif;
        }

        .welcome-message i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        /* Scrollbar Styling */
        #chat-history::-webkit-scrollbar {
            width: 6px;
        }

        #chat-history::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #chat-history::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        #chat-history::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            
            #chat-history {
                height: 300px;
            }
            
            .chat-bubble {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Chat Button -->
    <button class="btn" id="chatbot-toggler" data-bs-toggle="modal" data-bs-target="#chatbotModal">
        <i class="fa-solid fa-comments"></i>
    </button>

    <!-- Chat Modal -->
    <div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatbotModalLabel">
                        <i class="fa-solid fa-robot"></i> Project Assistant
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="chat-history">
                        <div class="chat-bubble bot">
                            Hello! I'm your Project Assistant. How can I help you today?
                        </div>
                        <div class="welcome-message">
                            <i class="fa-solid fa-lightbulb"></i>
                            <p>Ask me anything about your project!</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="input-group">
                        <input type="text" id="chat-input" class="form-control" placeholder="Type your message..." aria-label="Type your message">
                        <button class="btn btn-primary" type="button" id="send-chat-btn">
                            <i class="fa-solid fa-paper-plane"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatHistory = document.getElementById('chat-history');
            const chatInput = document.getElementById('chat-input');
            const sendBtn = document.getElementById('send-chat-btn');
            const welcomeMessage = document.querySelector('.welcome-message');

            // Function to add a message to the chat
            function addMessage(message, sender) {
                // Remove welcome message on first user message
                if (sender === 'user' && welcomeMessage) {
                    welcomeMessage.remove();
                }

                const bubble = document.createElement('div');
                bubble.classList.add('chat-bubble', sender);
                bubble.textContent = message;
                
                // Remove old loading message
                const loading = chatHistory.querySelector('.loading');
                if (loading) {
                    loading.remove();
                }

                chatHistory.appendChild(bubble);
                
                // Scroll to the bottom
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }

            // Function to show "thinking..." with typing animation
            function showLoading() {
                const bubble = document.createElement('div');
                bubble.classList.add('chat-bubble', 'loading');
                
                const typingIndicator = document.createElement('div');
                typingIndicator.classList.add('typing-indicator');
                
                for (let i = 0; i < 3; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('typing-dot');
                    typingIndicator.appendChild(dot);
                }
                
                bubble.innerHTML = 'Thinking';
                bubble.appendChild(typingIndicator);
                
                chatHistory.appendChild(bubble);
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }

            // Function to handle sending a message
            async function handleSendMessage() {
                const query = chatInput.value.trim();
                if (query === "") return;

                // 1. Add user's message to chat
                addMessage(query, 'user');
                chatInput.value = '';
                showLoading();

                try {
                    // 2. Get the CSRF token from the meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // 3. Send the query to the Laravel backend
                    const response = await fetch("{{ route('chatbot.query') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ query: query })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.answer || 'Network response was not ok.');
                    }

                    const data = await response.json();

                    // 4. Add the bot's response to the chat
                    addMessage(data.answer, 'bot');

                } catch (error) {
                    console.error('Error:', error);
                    addMessage('Sorry, something went wrong. (' + error.message + ')', 'bot');
                }
            }

            // --- Event Listeners ---
            // Send on button click
            sendBtn.addEventListener('click', handleSendMessage);

            // Send on "Enter" key press
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    handleSendMessage();
                }
            });

            // Focus input when modal opens
            const chatbotModal = document.getElementById('chatbotModal');
            chatbotModal.addEventListener('shown.bs.modal', function() {
                chatInput.focus();
            });
        });
    </script>
</body>