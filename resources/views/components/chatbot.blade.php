<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant</title>
    <!-- CSRF Token (you'll need to add this in your Laravel layout) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* Simple Floating Button */
        #chatbot-toggler {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #5e72e4;
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.2s ease;
        }

        #chatbot-toggler:hover {
            background: #4a5cd4;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(94, 114, 228, 0.4);
        }

        /* Simple Modal */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .modal-header {
            background: #5e72e4;
            color: white;
            border-bottom: none;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-title i {
            font-size: 1.2rem;
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 0;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 16px;
            background: #fff;
        }

        /* Chat History */
        #chat-history {
            height: 350px;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fe;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Simple Chat Bubbles */
        .chat-bubble {
            padding: 12px 16px;
            border-radius: 8px;
            max-width: 80%;
            word-wrap: break-word;
            line-height: 1.4;
            font-size: 0.9rem;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .chat-bubble.bot {
            background: white;
            color: #333;
            align-self: flex-start;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .chat-bubble.user {
            background: #5e72e4;
            color: white;
            align-self: flex-end;
        }

        .chat-bubble.loading {
            background: white;
            color: #666;
            align-self: flex-start;
            font-style: italic;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #666;
            animation: bounce 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        .typing-dot:nth-child(3) { animation-delay: 0s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Quick Reply Questions */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .quick-reply-btn {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 8px 16px;
            font-size: 0.85rem;
            color: #5e72e4;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .quick-reply-btn:hover {
            background: #f0f3ff;
            border-color: #5e72e4;
            transform: translateY(-1px);
        }

        /* Simple Input */
        .input-group {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        #chat-input {
            border: none;
            padding: 12px 16px;
            font-size: 0.9rem;
        }

        #chat-input:focus {
            outline: none;
            box-shadow: none;
        }

        #send-chat-btn {
            background: #5e72e4;
            border: none;
            padding: 0 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        #send-chat-btn:hover {
            background: #4a5cd4;
        }

        /* Welcome Message */
        .welcome-message {
            text-align: center;
            padding: 30px 20px;
            color: #666;
        }

        .welcome-message i {
            font-size: 2rem;
            color: #5e72e4;
            margin-bottom: 10px;
        }

        /* Scrollbar */
        #chat-history::-webkit-scrollbar {
            width: 6px;
        }

        #chat-history::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        #chat-history::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        #chat-history::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Mobile */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            
            #chat-history {
                height: 280px;
                padding: 16px;
            }
            
            #chatbot-toggler {
                bottom: 16px;
                right: 16px;
                width: 52px;
                height: 52px;
            }
            
            .quick-replies {
                gap: 6px;
            }
            
            .quick-reply-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Button -->
    <button class="btn" id="chatbot-toggler" data-bs-toggle="modal" data-bs-target="#chatbotModal">
        <i class="fa-solid fa-message"></i>
    </button>

    <!-- Chat Modal -->
    <div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="chatbotModalLabel">
                        <i class="fa-solid fa-robot text-white"></i> AI Assistant
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="chat-history">
                        <div class="chat-bubble bot">
                            Hi! I'm your AI assistant. How can I help you today?
                            <div class="quick-replies" id="initial-quick-replies">
                                <button class="quick-reply-btn" data-question="How do I create a team?">Create team</button>
                                <button class="quick-reply-btn" data-question="How do I submit a proposal?">Submit proposal</button>
                                <button class="quick-reply-btn" data-question="How do I manage expenses?">Manage expenses</button>
                                <button class="quick-reply-btn" data-question="How do I add team members?">Add members</button>
                            </div>
                        </div>
                        <div class="welcome-message">
                            <i class="fa-solid fa-comment"></i>
                            <p>Ask me anything about your GISO or About GISO360</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="input-group">
                        <input type="text" id="chat-input" class="form-control" placeholder="Type your question..." aria-label="Type your message">
                        <button class="btn btn-primary" type="button" id="send-chat-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript with Quick Reply Support -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatHistory = document.getElementById('chat-history');
            const chatInput = document.getElementById('chat-input');
            const sendBtn = document.getElementById('send-chat-btn');
            const welcomeMessage = document.querySelector('.welcome-message');
            
            // Common quick reply questions
            const commonQuestions = [
                "How do I create a team?",
                "How do I submit a proposal?",
                "How do I manage expenses?",
                "How do I add team members?",
                "What is GISO 360?",
                "How to schedule a presentation?",
                "How to review reports?",
                "How to track project progress?"
            ];

            function addMessage(message, sender) {
                if (sender === 'user' && welcomeMessage) {
                    welcomeMessage.remove();
                }

                const bubble = document.createElement('div');
                bubble.classList.add('chat-bubble', sender);
                bubble.textContent = message;
                
                const loading = chatHistory.querySelector('.loading');
                if (loading) {
                    loading.remove();
                }

                chatHistory.appendChild(bubble);
                chatHistory.scrollTop = chatHistory.scrollHeight;
                
                // Remove quick replies after user sends a message
                const quickReplies = document.querySelectorAll('.quick-replies');
                quickReplies.forEach(reply => reply.remove());
            }

            function showLoading() {
                const bubble = document.createElement('div');
                bubble.classList.add('chat-bubble', 'loading');
                
                const dots = document.createElement('div');
                dots.style.display = 'flex';
                dots.style.gap = '4px';
                
                for (let i = 0; i < 3; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('typing-dot');
                    dots.appendChild(dot);
                }
                
                bubble.innerHTML = 'Thinking';
                bubble.appendChild(dots);
                
                chatHistory.appendChild(bubble);
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }

            function addQuickReplies(questions) {
                const quickRepliesDiv = document.createElement('div');
                quickRepliesDiv.className = 'quick-replies';
                
                questions.forEach(question => {
                    const btn = document.createElement('button');
                    btn.className = 'quick-reply-btn';
                    btn.textContent = question;
                    btn.onclick = function() {
                        chatInput.value = question;
                        handleSendMessage();
                    };
                    quickRepliesDiv.appendChild(btn);
                });
                
                chatHistory.appendChild(quickRepliesDiv);
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }

            async function handleSendMessage() {
                const query = chatInput.value.trim();
                if (query === "") return;

                addMessage(query, 'user');
                chatInput.value = '';
                showLoading();

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                        throw new Error('Network error');
                    }

                    const data = await response.json();
                    addMessage(data.answer, 'bot');
                    
                    // Add relevant quick replies after bot response
                    setTimeout(() => {
                        if (query.includes('team') || query.includes('member')) {
                            addQuickReplies([
                                "How to remove a member?",
                                "How to change member role?",
                                "What are team roles?"
                            ]);
                        } else if (query.includes('proposal') || query.includes('report')) {
                            addQuickReplies([
                                "How to download a proposal?",
                                "What file formats are supported?",
                                "How to check proposal status?"
                            ]);
                        } else if (query.includes('expense') || query.includes('finance')) {
                            addQuickReplies([
                                "How to add an expense?",
                                "How to view expense reports?",
                                "What are expense categories?"
                            ]);
                        } else {
                            // Add some general quick replies
                            const generalReplies = commonQuestions.slice(0, 3);
                            addQuickReplies(generalReplies);
                        }
                    }, 300);

                } catch (error) {
                    console.error('Error:', error);
                    addMessage('Sorry, something went wrong. Please try again.', 'bot');
                }
            }

            // Event Listeners
            sendBtn.addEventListener('click', handleSendMessage);

            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    handleSendMessage();
                }
            });

            // Quick reply button click handlers
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quick-reply-btn')) {
                    const question = e.target.dataset.question || e.target.textContent;
                    chatInput.value = question;
                    handleSendMessage();
                }
            });

            const chatbotModal = document.getElementById('chatbotModal');
            chatbotModal.addEventListener('shown.bs.modal', function() {
                chatInput.focus();
            });
        });
    </script>
</body>