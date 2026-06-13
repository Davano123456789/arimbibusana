<!-- Floating Chat Widget -->
<div class="fixed bottom-6 right-6 z-50 font-sans">
    <!-- Chat Button -->
    <button id="chat-toggle-btn" class="w-14 h-14 bg-gradient-to-tr from-accent to-cream-dark text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none">
        <span class="relative">
            <i id="chat-icon" class="fa-solid fa-comments text-2xl"></i>
            <!-- Unread badge (initially hidden) -->
            <span id="chat-unread-badge" class="absolute -top-3 -right-3 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full hidden">0</span>
        </span>
    </button>

    <!-- Contact Options Menu -->
    <div id="contact-options-menu" class="absolute bottom-16 right-0 flex flex-col items-end gap-3 opacity-0 scale-90 pointer-events-none origin-bottom-right transition-all duration-300 z-50">
        <!-- WhatsApp Option -->
        <a href="https://wa.me/6282337115553" target="_blank" class="flex items-center gap-2.5 bg-[#25D366] text-white px-5 py-3 rounded-full shadow-lg hover:scale-105 active:scale-95 transition whitespace-nowrap text-sm font-semibold">
            <i class="fa-brands fa-whatsapp text-lg"></i>
            Hubungi via WhatsApp
        </a>
        <!-- Live Chat Option -->
        <button id="open-live-chat-btn" class="flex items-center gap-2.5 bg-gradient-to-tr from-accent to-cream-dark text-white px-5 py-3 rounded-full shadow-lg hover:scale-105 active:scale-95 transition whitespace-nowrap text-sm font-semibold">
            <i class="fa-solid fa-comments text-base"></i>
            Chat Langsung (Website)
        </button>
    </div>

    <!-- Chat Window Container -->
    <div id="chat-window" class="absolute bottom-16 right-0 w-80 sm:w-96 h-[480px] bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden opacity-0 scale-90 pointer-events-none origin-bottom-right transition-all duration-300">
        <!-- Header -->
        <div class="bg-gradient-to-r from-accent to-cream-dark px-5 py-4 text-white flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <i class="fa-solid fa-user-tie text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm leading-tight">Customer Service</h4>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="text-xs text-cream/90">Online</span>
                    </div>
                </div>
            </div>
            <button id="chat-close-btn" class="text-white/80 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-4 bg-amber-50/20 space-y-3 scrollbar-thin" id="chat-body">
            @auth
                <!-- Loading indicator -->
                <div id="chat-loading" class="flex justify-center items-center py-8 text-gray-400 gap-2">
                    <i class="fa-solid fa-spinner animate-spin"></i>
                    <span class="text-sm">Memuat pesan...</span>
                </div>
                <!-- Message container -->
                <div id="chat-messages-container" class="space-y-3"></div>
            @else
                <!-- Guest state prompt -->
                <div class="h-full flex flex-col items-center justify-center text-center p-6 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-cream/35 flex items-center justify-center text-accent">
                        <i class="fa-solid fa-lock text-2xl"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800">Yuk, Masuk Dulu!</h5>
                        <p class="text-sm text-gray-500 mt-1">Anda perlu masuk atau mendaftar untuk memulai obrolan dengan Admin kami.</p>
                    </div>
                    <div class="flex flex-col w-full gap-2 pt-2">
                        <a href="{{ route('login') }}" class="w-full py-2.5 bg-accent hover:bg-accent/90 text-white rounded-xl text-sm font-semibold transition shadow-md">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full py-2.5 border border-accent/30 hover:bg-cream/20 text-accent rounded-xl text-sm font-semibold transition">Daftar</a>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Footer -->
        @auth
            <form id="chat-form" class="bg-white border-t border-gray-100 flex flex-col">
                <!-- Image Preview Container -->
                <div id="image-preview-container" class="px-3 py-2 bg-gray-50 border-b border-gray-100 flex items-center justify-between hidden">
                    <div class="flex items-center gap-2">
                        <img id="image-preview-img" src="" class="w-10 h-10 object-cover rounded-lg border">
                        <span class="text-xs text-gray-500 truncate max-w-[150px]" id="image-preview-filename">-</span>
                    </div>
                    <button type="button" id="image-preview-cancel" class="text-gray-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                
                <div class="p-3 flex items-center gap-2">
                    <input type="file" id="chat-image-input" accept="image/*" class="hidden">
                    <button type="button" id="chat-attachment-btn" class="w-10 h-10 bg-gray-50 text-gray-500 rounded-xl flex items-center justify-center hover:bg-gray-100 transition shrink-0" title="Kirim Gambar">
                        <i class="fa-solid fa-image text-sm"></i>
                    </button>
                    <input type="text" id="chat-input" placeholder="Tulis pesan Anda..." class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-accent/50 focus:bg-white transition" required autocomplete="off">
                    <button type="submit" class="w-10 h-10 bg-accent text-white rounded-xl flex items-center justify-center hover:bg-accent/90 transition shadow-md shrink-0">
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </form>
        @endauth
    </div>
</div>

<!-- Scripts for Pusher, Echo, and SweetAlert2 CDNs -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatCloseBtn = document.getElementById('chat-close-btn');
    const chatWindow = document.getElementById('chat-window');
    const chatIcon = document.getElementById('chat-icon');
    const chatBody = document.getElementById('chat-body');
    const chatUnreadBadge = document.getElementById('chat-unread-badge');
    
    const contactOptionsMenu = document.getElementById('contact-options-menu');
    const openLiveChatBtn = document.getElementById('open-live-chat-btn');
    
    let isMenuOpen = false;
    let isChatOpen = false;
    let hasLoadedMessages = false;
    let unreadCount = 0;

    // Helper functions to open/close menu
    function openMenu() {
        contactOptionsMenu.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
        contactOptionsMenu.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        chatIcon.className = 'fa-solid fa-xmark text-2xl';
        isMenuOpen = true;
    }

    function closeMenu() {
        contactOptionsMenu.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
        contactOptionsMenu.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
        chatIcon.className = 'fa-solid fa-comments text-2xl';
        isMenuOpen = false;
    }

    // Helper functions to open/close chat window
    function openChat() {
        chatWindow.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
        chatWindow.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        chatIcon.className = 'fa-solid fa-chevron-down text-2xl';
        isChatOpen = true;

        // Clear unread badge
        unreadCount = 0;
        chatUnreadBadge.classList.add('hidden');
        chatUnreadBadge.textContent = '0';

        // Load messages if authenticated
        @auth
            if (!hasLoadedMessages) {
                loadChatMessages();
            } else {
                scrollToBottom();
                markMessagesRead();
            }
        @endauth
    }

    function closeChat() {
        chatWindow.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
        chatWindow.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
        chatIcon.className = 'fa-solid fa-comments text-2xl';
        isChatOpen = false;
    }

    // Toggle click on main button
    chatToggleBtn.addEventListener('click', function() {
        if (isChatOpen) {
            closeChat();
        } else if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Option menu Live Chat click
    if (openLiveChatBtn) {
        openLiveChatBtn.addEventListener('click', function() {
            closeMenu();
            openChat();
        });
    }

    // Header close button in Chat Window
    if (chatCloseBtn) {
        chatCloseBtn.addEventListener('click', function() {
            closeChat();
        });
    }

    @auth
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessagesContainer = document.getElementById('chat-messages-container');
        const chatLoading = document.getElementById('chat-loading');
        const currentUserId = {{ auth()->id() }};

        // Initialize Laravel Echo via CDN
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        // Listen for new messages on private user channel
        window.Echo.private('chat.' + currentUserId)
            .listen('MessageSent', (e) => {
                appendMessage(e, 'admin');
                scrollToBottom();

                if (isChatOpen) {
                    markMessagesRead();
                } else {
                    unreadCount++;
                    chatUnreadBadge.classList.remove('hidden');
                    chatUnreadBadge.textContent = unreadCount;
                    
                    // Simple sound notification if desired in future
                    try {
                        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-84.wav');
                        audio.volume = 0.4;
                        audio.play();
                    } catch(e) {}
                }
            })
            .listen('MessageDeleted', (e) => {
                const bubble = document.getElementById(`msg-bubble-${e.message_id}`);
                if (bubble) {
                    bubble.classList.add('opacity-0', 'scale-90');
                    setTimeout(() => {
                        bubble.remove();
                    }, 250);
                }
            });

        // Fetch Chat History
        async function loadChatMessages() {
            try {
                const response = await fetch('/chat/messages/admin');
                const messages = await response.json();
                
                chatLoading.classList.add('hidden');
                chatMessagesContainer.innerHTML = '';
                
                if (messages.length === 0) {
                    chatMessagesContainer.innerHTML = `
                        <div class="text-center py-12 text-gray-400 text-xs">
                            <i class="fa-solid fa-message text-2xl mb-2 text-gray-300 block"></i>
                            Mulai percakapan Anda dengan Admin. Kirim pesan di bawah ini!
                        </div>
                    `;
                } else {
                    messages.forEach(msg => {
                        const senderType = msg.sender_id === currentUserId ? 'client' : 'admin';
                        appendMessage(msg, senderType);
                    });
                }
                
                hasLoadedMessages = true;
                scrollToBottom();
            } catch (error) {
                console.error('Gagal memuat pesan:', error);
                chatLoading.innerHTML = `
                    <div class="text-center text-red-500 text-xs py-4">
                        Gagal memuat riwayat obrolan. <button onclick="loadChatMessages()" class="underline font-semibold">Coba lagi</button>
                    </div>
                `;
            }
        }

        const chatImageInput = document.getElementById('chat-image-input');
        const chatAttachmentBtn = document.getElementById('chat-attachment-btn');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imagePreviewImg = document.getElementById('image-preview-img');
        const imagePreviewFilename = document.getElementById('image-preview-filename');
        const imagePreviewCancel = document.getElementById('image-preview-cancel');

        // Click handler for attachment button
        chatAttachmentBtn.addEventListener('click', () => {
            chatImageInput.click();
        });

        // Change handler for image input (show preview)
        chatImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviewImg.src = e.target.result;
                    imagePreviewFilename.textContent = file.name;
                    imagePreviewContainer.classList.remove('hidden');
                    chatInput.removeAttribute('required');
                };
                reader.readAsDataURL(file);
            }
        });

        // Cancel preview handler
        imagePreviewCancel.addEventListener('click', function() {
            chatImageInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            imagePreviewImg.src = '';
            chatInput.setAttribute('required', '');
        });

        // Send Message
        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const text = chatInput.value.trim();
            const file = chatImageInput.files[0];
            if (!text && !file) return;

            // Reset inputs & preview
            chatInput.value = '';
            chatImageInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            chatInput.setAttribute('required', '');

            const tempId = 'temp-' + Date.now();
            const tempMsg = {
                id: tempId,
                message: text,
                image: file ? URL.createObjectURL(file) : null,
                created_at: new Date().toISOString()
            };
            appendMessage(tempMsg, 'client');
            scrollToBottom();

            // Remove empty screen prompt if there
            const emptyPrompt = chatMessagesContainer.querySelector('.text-center');
            if (emptyPrompt) emptyPrompt.remove();

            const formData = new FormData();
            if (text) formData.append('message', text);
            if (file) formData.append('image', file);

            try {
                const response = await fetch('/chat/messages', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Gagal mengirim pesan');
                }
                
                const data = await response.json();
                
                const tempEl = document.getElementById(`msg-bubble-${tempId}`);
                if (tempEl && data.message) {
                    tempEl.id = `msg-bubble-${data.message.id}`;
                    const timeEl = tempEl.querySelector('.time-text');
                    if (timeEl) {
                        timeEl.textContent = formatTime(data.message.created_at);
                    }
                    if (data.message.image) {
                        const imgEl = tempEl.querySelector('img');
                        if (imgEl) imgEl.src = '/storage/' + data.message.image;
                    }
                    const deleteBtn = tempEl.querySelector('.delete-msg-btn');
                    if (deleteBtn) {
                        deleteBtn.setAttribute('data-id', data.message.id);
                    }
                }
            } catch (error) {
                console.error('Gagal mengirim pesan:', error);
                const tempEl = document.getElementById(`msg-bubble-${tempId}`);
                if (tempEl) {
                    tempEl.classList.add('opacity-60');
                    const errorIndicator = document.createElement('span');
                    errorIndicator.className = 'text-[10px] text-red-500 flex items-center gap-1 justify-end mt-1';
                    errorIndicator.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Gagal terkirim';
                    tempEl.querySelector('.bubble-content').appendChild(errorIndicator);
                }
            }
        });

        // Delete / Unsend message click handler
        document.addEventListener('click', async function(e) {
            const deleteBtn = e.target.closest('.delete-msg-btn');
            if (!deleteBtn) return;

            const messageId = deleteBtn.getAttribute('data-id');
            if (!messageId || messageId.startsWith('temp-')) return;

            Swal.fire({
                title: 'Tarik Pesan?',
                text: "Pesan ini akan dihapus untuk Anda dan Admin.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5B3A29', // Accent color
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tarik!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/chat/messages/${messageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (!response.ok) throw new Error('Gagal menarik pesan');

                        // Remove bubble from client side immediately
                        const bubble = document.getElementById(`msg-bubble-${messageId}`);
                        if (bubble) {
                            bubble.classList.add('opacity-0', 'scale-90');
                            setTimeout(() => {
                                bubble.remove();
                                if (chatMessagesContainer.children.length === 0) {
                                    chatMessagesContainer.innerHTML = `
                                        <div class="text-center py-12 text-gray-400 text-xs">
                                            <i class="fa-solid fa-message text-2xl mb-2 text-gray-300 block"></i>
                                            Mulai percakapan Anda dengan Admin. Kirim pesan di bawah ini!
                                        </div>
                                    `;
                                }
                            }, 250);
                        }
                    } catch (error) {
                        console.error('Gagal menarik pesan:', error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menarik pesan. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonColor: '#5B3A29'
                        });
                    }
                }
            });
        });

        // Append message to HTML container
        function appendMessage(msg, senderType) {
            const timeFormatted = formatTime(msg.created_at);
            const isClient = senderType === 'client';
            
            let imageHtml = '';
            if (msg.image) {
                const imgSrc = msg.image.startsWith('blob:') || msg.image.startsWith('data:') 
                    ? msg.image 
                    : '/storage/' + msg.image;
                imageHtml = `
                    <div class="mb-2">
                        <img src="${imgSrc}" class="rounded-xl max-w-full h-auto max-h-48 object-cover border cursor-pointer hover:opacity-90 transition" onclick="window.open('${imgSrc}', '_blank')">
                    </div>
                `;
            }

            const textHtml = msg.message 
                ? `<p class="text-sm leading-relaxed whitespace-pre-line break-words">${escapeHtml(msg.message)}</p>`
                : '';
            
            const bubbleHtml = `
                <div class="flex ${isClient ? 'justify-end' : 'justify-start'} items-center gap-1.5 animate-fade-in group relative" id="msg-bubble-${msg.id}">
                    ${isClient ? `
                    <button class="delete-msg-btn md:opacity-0 group-hover:opacity-100 text-gray-400 hover:text-red-500 transition-opacity duration-200 p-2 border-0 bg-transparent shrink-0" data-id="${msg.id}" title="Tarik Pesan">
                        <i class="fa-solid fa-trash text-[11px]"></i>
                    </button>
                    ` : ''}
                    <div class="max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm bubble-content ${
                        isClient 
                            ? 'bg-gradient-to-tr from-accent to-cream-dark text-white rounded-tr-none' 
                            : 'bg-white text-gray-800 border border-gray-100 rounded-tl-none'
                    }">
                        ${imageHtml}
                        ${textHtml}
                        <span class="time-text text-[9px] block text-right mt-1 ${isClient ? 'text-white/75' : 'text-gray-400'}">
                            ${timeFormatted}
                        </span>
                    </div>
                </div>
            `;
            
            chatMessagesContainer.insertAdjacentHTML('beforeend', bubbleHtml);
        }

        // Mark Messages as Read
        async function markMessagesRead() {
            try {
                // Fetch gets the messages and automatically marks unread from admin as read
                fetch('/chat/messages/admin');
            } catch(e) {}
        }

        // Scroll helper
        function scrollToBottom() {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Format Date string to short time (HH:MM)
        function formatTime(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        // Escape helper to prevent HTML injection
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    @endauth
});
</script>

<style>
/* Small animations and scrollbar tweaks */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.25s ease forwards;
}
.scrollbar-thin::-webkit-scrollbar {
    width: 5px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 99px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.2);
}

/* Contact Menu Hover Lift */
#contact-options-menu a, #contact-options-menu button {
    transition: all 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);
}
#contact-options-menu a:hover, #contact-options-menu button:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.18);
}
</style>
