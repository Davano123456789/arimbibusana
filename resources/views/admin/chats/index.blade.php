@extends('layouts.masterDashboard')

@section('title', 'Chat Pelanggan - Arimbi Busana')

@section('content')
<div class="row h-100">
    <!-- Left Pane: Client List -->
    <div class="col-lg-4 col-md-5 mb-4">
        <div class="card shadow-sm h-100 flex-column" style="max-height: calc(100vh - 180px); min-height: 550px;">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                <div>
                    <h6 class="font-weight-bolder mb-1">Obrolan Pelanggan</h6>
                    <p class="text-xs text-muted">Hubungi client secara real-time</p>
                </div>
                <!-- Start New Chat Trigger -->
                <button class="btn btn-xs btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#newChatModal">
                    <i class="fa-solid fa-plus me-1"></i> Baru
                </button>
            </div>
            <!-- Search Client -->
            <div class="px-3 pt-3">
                <div class="input-group input-group-alternative input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" id="search-client" class="form-control bg-light border-0" placeholder="Cari nama pelanggan..." style="padding-left: 8px;">
                </div>
            </div>
            <!-- Client List Container -->
            <div class="card-body px-0 py-2 overflow-auto flex-fill" style="height: 380px;" id="client-list">
                @if($chattedClients->isEmpty())
                    <div class="text-center py-5 text-muted" id="empty-clients-placeholder">
                        <i class="fa-solid fa-comment-slash text-2xl mb-2 text-gray-300"></i>
                        <p class="text-xs">Belum ada obrolan aktif.</p>
                        <p class="text-xxs">Klik tombol "+" untuk memulai obrolan baru.</p>
                    </div>
                @endif
                
                <div class="list-group list-group-flush" id="clients-container">
                    @foreach($chattedClients as $client)
                        <a href="javascript:void(0);" 
                           class="list-group-item list-group-item-action border-0 px-3 py-3 client-item d-flex align-items-center gap-3 transition" 
                           data-id="{{ $client->id }}" 
                           data-name="{{ $client->name }}"
                           data-email="{{ $client->email }}">
                            <div class="avatar avatar-sm bg-gradient-primary rounded-circle shrink-0 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr($client->name, 0, 2)) }}
                            </div>
                            <div class="flex-fill overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-sm font-weight-bold mb-0 text-truncate text-dark client-name-text">{{ $client->name }}</h6>
                                    <span class="text-xxs text-muted last-msg-time">
                                        {{ $client->last_message ? $client->last_message->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <p class="text-xs text-muted mb-0 text-truncate last-msg-body" style="max-width: 170px;">
                                        {{ $client->last_message ? $client->last_message->message : 'Mulai chat...' }}
                                    </p>
                                    <span class="badge badge-sm bg-danger rounded-circle unread-badge {{ $client->unread_count > 0 ? '' : 'd-none' }}">
                                        {{ $client->unread_count }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Right Pane: Active Chat Window -->
    <div class="col-lg-8 col-md-7 mb-4">
        <div class="card shadow-sm h-100 d-flex flex-column" style="max-height: calc(100vh - 180px); min-height: 550px;" id="chat-window-pane">
            <!-- No Selected Active Chat View -->
            <div id="no-chat-selected" class="h-100 flex-column justify-content-center align-items-center text-center p-5 flex-fill d-flex">
                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow-lg mb-4 flex items-center justify-center" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-comments text-3xl"></i>
                </div>
                <h5 class="font-weight-bold text-dark">Layanan Chat Admin</h5>
                <p class="text-sm text-muted max-w-sm mt-2">Pilih pelanggan di panel kiri atau buat obrolan baru untuk melihat pesan dan mulai membalas.</p>
            </div>

            <!-- Active Chat View (Initially Hidden) -->
            <div id="active-chat" class="h-100 flex-column flex-fill d-none">
                <!-- Header -->
                <div class="card-header pb-3 d-flex justify-content-between align-items-center bg-transparent border-bottom shadow-xs">
                    <div class="d-flex align-items-center gap-3">
                        <div id="active-avatar" class="avatar avatar-md bg-gradient-primary rounded-circle text-white font-weight-bold d-flex align-items-center justify-content-center">
                            CP
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-0 text-dark" id="active-client-name">-</h6>
                            <span class="text-xs text-muted" id="active-client-email">-</span>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages Body -->
                <div class="card-body bg-light-gray overflow-auto p-4 flex-fill position-relative" style="height: 350px; background-color: #f8f9fa;" id="admin-chat-body">
                    <!-- Spinner for loading -->
                    <div id="admin-chat-loading" class="position-absolute top-50 start-50 translate-middle text-center text-muted d-none">
                        <i class="fa-solid fa-spinner animate-spin text-2xl mb-2 text-primary"></i>
                        <p class="text-xs">Memuat pesan obrolan...</p>
                    </div>

                    <div id="admin-messages-container" class="space-y-3 d-flex flex-column gap-3">
                        <!-- Message Bubbles will inject here -->
                    </div>
                </div>

                <!-- Footer / Input Form -->
                <div class="card-footer p-3 bg-white border-top">
                    <form id="admin-chat-form" class="d-flex flex-column gap-2">
                        <!-- Image Preview Container -->
                        <div id="admin-image-preview-container" class="px-3 py-2 bg-light border rounded flex align-items-center justify-content-between d-none">
                            <div class="d-flex align-items-center gap-2">
                                <img id="admin-image-preview-img" src="" class="rounded border" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="text-xs text-muted truncate max-w-200" id="admin-image-preview-filename">-</span>
                            </div>
                            <button type="button" id="admin-image-preview-cancel" class="btn btn-link text-danger p-0 m-0">
                                <i class="fa-solid fa-circle-xmark text-lg"></i>
                            </button>
                        </div>
                        
                        <div class="d-flex gap-2 align-items-center">
                            <input type="file" id="admin-chat-image-input" accept="image/*" class="d-none">
                            <button type="button" id="admin-chat-attachment-btn" class="btn btn-outline-secondary rounded-circle p-0 m-0 flex align-items-center justify-center shrink-0" style="width: 44px; height: 44px;" title="Kirim Gambar">
                                <i class="fa-solid fa-image text-sm"></i>
                            </button>
                            <input type="text" id="admin-chat-input" class="form-control rounded-pill border-gray-300" placeholder="Tulis balasan Anda ke pelanggan..." required autocomplete="off">
                            <button type="submit" class="btn btn-primary rounded-circle flex items-center justify-center p-0 shadow-md shrink-0" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-paper-plane text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Start New Chat -->
<div class="modal fade" id="newChatModal" tabindex="-1" aria-labelledby="newChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-radius-md">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold" id="newChatModalLabel">Mulai Obrolan Baru</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="input-group input-group-alternative mb-3">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" id="search-modal-client" class="form-control bg-light border-0" placeholder="Cari nama client...">
                </div>
                <div class="overflow-auto" style="max-height: 300px;" id="modal-clients-list">
                    <div class="list-group list-group-flush" id="modal-clients-container">
                        @forelse($allClients as $client)
                            <a href="javascript:void(0);" 
                               class="list-group-item list-group-item-action border-0 py-2.5 px-2 d-flex align-items-center gap-3 modal-client-item" 
                               data-id="{{ $client->id }}" 
                               data-name="{{ $client->name }}"
                               data-email="{{ $client->email }}">
                                <div class="avatar avatar-sm bg-light text-primary rounded-circle font-weight-bold d-flex align-items-center justify-content-center">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h6 class="text-sm font-weight-bold mb-0 text-dark modal-client-name">{{ $client->name }}</h6>
                                    <span class="text-xs text-muted">{{ $client->email }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted text-xs">
                                Belum ada pelanggan terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Pusher & Echo CDNs -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const clientsContainer = document.getElementById('clients-container');
    const noChatSelected = document.getElementById('no-chat-selected');
    const activeChat = document.getElementById('active-chat');
    const activeClientName = document.getElementById('active-client-name');
    const activeClientEmail = document.getElementById('active-client-email');
    const activeAvatar = document.getElementById('active-avatar');
    const adminChatBody = document.getElementById('admin-chat-body');
    const adminMessagesContainer = document.getElementById('admin-messages-container');
    const adminChatLoading = document.getElementById('admin-chat-loading');
    const adminChatForm = document.getElementById('admin-chat-form');
    const adminChatInput = document.getElementById('admin-chat-input');
    const searchClient = document.getElementById('search-client');
    const searchModalClient = document.getElementById('search-modal-client');

    const currentUserId = {{ auth()->id() }};
    let activeClientId = null;

    // Filter Client List
    searchClient.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('.client-item').forEach(item => {
            const name = item.querySelector('.client-name-text').textContent.toLowerCase();
            if (name.includes(query)) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    });

    // Filter Modal Client List
    searchModalClient.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('.modal-client-item').forEach(item => {
            const name = item.querySelector('.modal-client-name').textContent.toLowerCase();
            if (name.includes(query)) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    });

    // Handle Client Selection in list or modal
    document.addEventListener('click', function(e) {
        const clientItem = e.target.closest('.client-item, .modal-client-item');
        if (!clientItem) return;

        const id = clientItem.getAttribute('data-id');
        const name = clientItem.getAttribute('data-name');
        const email = clientItem.getAttribute('data-email');

        // Close modal if selection was inside modal
        if (clientItem.classList.contains('modal-client-item')) {
            const modalEl = document.getElementById('newChatModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            
            // Add or move client to active client list if they aren't there
            ensureClientInList(id, name, email);
        }

        selectClient(id, name, email);
    });

    // Function to ensure client is in left-hand sidebar
    function ensureClientInList(id, name, email) {
        let clientEl = document.querySelector(`.client-item[data-id="${id}"]`);
        if (!clientEl) {
            // Remove empty placeholder if any
            const placeholder = document.getElementById('empty-clients-placeholder');
            if (placeholder) placeholder.remove();

            const initials = name.substring(0, 2).toUpperCase();
            const newHtml = `
                <a href="javascript:void(0);" 
                   class="list-group-item list-group-item-action border-0 px-3 py-3 client-item d-flex align-items-center gap-3 transition" 
                   data-id="${id}" 
                   data-name="${name}"
                   data-email="${email}">
                    <div class="avatar avatar-sm bg-gradient-primary rounded-circle shrink-0 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                        ${initials}
                    </div>
                    <div class="flex-fill overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-sm font-weight-bold mb-0 text-truncate text-dark client-name-text">${name}</h6>
                            <span class="text-xxs text-muted last-msg-time">Sekarang</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <p class="text-xs text-muted mb-0 text-truncate last-msg-body" style="max-width: 170px;">Mulai chat...</p>
                            <span class="badge badge-sm bg-danger rounded-circle unread-badge d-none">0</span>
                        </div>
                    </div>
                </a>
            `;
            if (clientsContainer) {
                clientsContainer.insertAdjacentHTML('afterbegin', newHtml);
            } else {
                // If container didn't exist (because list was empty)
                const listContainer = document.getElementById('client-list');
                listContainer.innerHTML = `<div class="list-group list-group-flush" id="clients-container">${newHtml}</div>`;
            }
        }
    }

    // Set Active Chat Selection
    function selectClient(id, name, email) {
        activeClientId = id;
        
        // Remove active class from other client items
        document.querySelectorAll('.client-item').forEach(item => {
            item.classList.remove('active', 'bg-light');
            item.querySelector('.client-name-text').classList.remove('text-white');
        });

        // Set active styling
        const activeItem = document.querySelector(`.client-item[data-id="${id}"]`);
        if (activeItem) {
            activeItem.classList.add('bg-light');
            // Hide unread badge
            const badge = activeItem.querySelector('.unread-badge');
            if (badge) {
                badge.classList.add('d-none');
                badge.textContent = '0';
            }
        }

        // Show chat pane
        noChatSelected.classList.remove('d-flex');
        noChatSelected.classList.add('d-none');
        activeChat.classList.remove('d-none');
        activeChat.classList.add('d-flex');

        // Set header details
        activeClientName.textContent = name;
        activeClientEmail.textContent = email;
        activeAvatar.textContent = name.substring(0, 2).toUpperCase();

        loadMessages(id);
    }

    // Fetch Messages between Admin and Client
    async function loadMessages(clientId) {
        adminMessagesContainer.innerHTML = '';
        adminChatLoading.classList.remove('d-none');

        try {
            const response = await fetch(`/chat/messages/${clientId}`);
            const messages = await response.json();
            adminChatLoading.classList.add('d-none');

            messages.forEach(msg => {
                const type = msg.sender_id === currentUserId ? 'admin' : 'client';
                appendMessage(msg, type);
            });
            scrollToBottom();
        } catch (error) {
            console.error('Error loading messages:', error);
            adminChatLoading.innerHTML = `
                <div class="text-center text-danger text-xs py-4">
                    Gagal memuat pesan. <button onclick="loadMessages(${clientId})" class="btn btn-link text-primary text-xs p-0 m-0">Coba lagi</button>
                </div>
            `;
        }
    }

    const adminChatImageInput = document.getElementById('admin-chat-image-input');
    const adminChatAttachmentBtn = document.getElementById('admin-chat-attachment-btn');
    const adminImagePreviewContainer = document.getElementById('admin-image-preview-container');
    const adminImagePreviewImg = document.getElementById('admin-image-preview-img');
    const adminImagePreviewFilename = document.getElementById('admin-image-preview-filename');
    const adminImagePreviewCancel = document.getElementById('admin-image-preview-cancel');

    // Click handler for attachment button
    adminChatAttachmentBtn.addEventListener('click', () => {
        adminChatImageInput.click();
    });

    // Change handler for image input (show preview)
    adminChatImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                adminImagePreviewImg.src = e.target.result;
                adminImagePreviewFilename.textContent = file.name;
                adminImagePreviewContainer.classList.remove('d-none');
                adminChatInput.removeAttribute('required');
            };
            reader.readAsDataURL(file);
        }
    });

    // Cancel preview handler
    adminImagePreviewCancel.addEventListener('click', function() {
        adminChatImageInput.value = '';
        adminImagePreviewContainer.classList.add('d-none');
        adminImagePreviewImg.src = '';
        adminChatInput.setAttribute('required', '');
    });

    // Append Message HTML bubble
    function appendMessage(msg, type) {
        const isAdmin = type === 'admin';
        const initials = isAdmin ? 'AD' : activeClientName.textContent.substring(0, 2).toUpperCase();
        const timeFormatted = formatTime(msg.created_at);

        let imageHtml = '';
        if (msg.image) {
            const imgSrc = msg.image.startsWith('blob:') || msg.image.startsWith('data:') 
                ? msg.image 
                : '/storage/' + msg.image;
            imageHtml = `
                <div class="mb-2">
                    <img src="${imgSrc}" class="rounded border cursor-pointer hover:opacity-90 transition" style="max-width: 100%; max-height: 250px; object-fit: cover;" onclick="window.open('${imgSrc}', '_blank')">
                </div>
            `;
        }

        const textHtml = msg.message 
            ? `<p class="text-sm mb-0 whitespace-pre-line break-words" style="line-height: 1.4;">${escapeHtml(msg.message)}</p>`
            : '';

        const bubbleHtml = `
            <div class="d-flex ${isAdmin ? 'justify-content-end' : 'justify-start'} mb-3 chat-bubble-row" id="admin-msg-${msg.id}">
                <div class="d-flex align-items-end gap-2 max-w-70">
                    ${!isAdmin ? `<div class="avatar avatar-xs bg-gradient-secondary rounded-circle text-[9px] d-flex align-items-center justify-content-center text-white shrink-0 shadow-xs">${initials}</div>` : ''}
                    
                    ${isAdmin ? `
                    <button class="btn btn-link btn-xs text-muted p-0 m-0 me-2 delete-btn align-self-center border-0 bg-transparent" data-id="${msg.id}" title="Tarik Pesan">
                        <i class="fa-solid fa-trash text-xxs"></i>
                    </button>
                    ` : ''}
                    
                    <div class="rounded-3 px-3 py-2 shadow-xs ${
                        isAdmin 
                            ? 'bg-primary text-white rounded-bottom-end-0' 
                            : 'bg-white text-dark border rounded-bottom-start-0'
                    }">
                        ${imageHtml}
                        ${textHtml}
                        <span class="text-[9px] d-block text-end mt-1 ${isAdmin ? 'text-white-50' : 'text-muted'}">
                            ${timeFormatted}
                        </span>
                    </div>
                </div>
            </div>
        `;
        adminMessagesContainer.insertAdjacentHTML('beforeend', bubbleHtml);
    }

    // Send Reply Message
    adminChatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = adminChatInput.value.trim();
        const file = adminChatImageInput.files[0];
        if ((!text && !file) || !activeClientId) return;

        // Reset inputs and preview immediately
        adminChatInput.value = '';
        adminChatImageInput.value = '';
        adminImagePreviewContainer.classList.add('d-none');
        adminChatInput.setAttribute('required', '');

        const tempId = 'temp-' + Date.now();
        const tempMsg = {
            id: tempId,
            message: text,
            image: file ? URL.createObjectURL(file) : null,
            created_at: new Date().toISOString()
        };
        appendMessage(tempMsg, 'admin');
        scrollToBottom();

        const formData = new FormData();
        if (text) formData.append('message', text);
        if (file) formData.append('image', file);
        formData.append('receiver_id', activeClientId);

        try {
            const response = await fetch('/chat/messages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            if (!response.ok) throw new Error('Failed to send');

            const data = await response.json();
            
            const tempEl = document.getElementById(`admin-msg-${tempId}`);
            if (tempEl && data.message) {
                tempEl.id = `admin-msg-${data.message.id}`;
                const timeEl = tempEl.querySelector('.text-white-50');
                if (timeEl) timeEl.textContent = formatTime(data.message.created_at);
                if (data.message.image) {
                    const imgEl = tempEl.querySelector('img');
                    if (imgEl) imgEl.src = '/storage/' + data.message.image;
                }
                const deleteBtn = tempEl.querySelector('.delete-btn');
                if (deleteBtn) {
                    deleteBtn.setAttribute('data-id', data.message.id);
                }
            }

            updateClientListItem(activeClientId, text || '[Gambar]', new Date().toISOString());
        } catch (error) {
            console.error('Error sending message:', error);
            const tempEl = document.getElementById(`admin-msg-${tempId}`);
            if (tempEl) {
                tempEl.classList.add('opacity-60');
                const err = document.createElement('div');
                err.className = 'text-[9px] text-danger mt-1 text-end';
                err.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Gagal';
                tempEl.querySelector('.rounded-3').appendChild(err);
            }
        }
    });

    // Update Client details on left pane list item
    function updateClientListItem(clientId, messageText, timeIso) {
        const clientEl = document.querySelector(`.client-item[data-id="${clientId}"]`);
        if (clientEl) {
            // Update last message preview
            const bodyEl = clientEl.querySelector('.last-msg-body');
            if (bodyEl) bodyEl.textContent = messageText;

            // Update time
            const timeEl = clientEl.querySelector('.last-msg-time');
            if (timeEl) {
                const date = new Date(timeIso);
                timeEl.textContent = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }

            // Move to top of the stack
            const container = document.getElementById('clients-container');
            if (container) {
                container.prepend(clientEl);
            }
        }
    }

    // Scroll helper
    function scrollToBottom() {
        adminChatBody.scrollTop = adminChatBody.scrollHeight;
    }

    // Format Date string
    function formatTime(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    // Escape helper
    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Delete message click handler for Admin
    document.addEventListener('click', async function(e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (!deleteBtn) return;

        const messageId = deleteBtn.getAttribute('data-id');
        if (!messageId || messageId.startsWith('temp-')) return;

        Swal.fire({
            title: 'Tarik Pesan?',
            text: "Pesan ini akan dihapus untuk Anda dan pelanggan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
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

                    if (!response.ok) throw new Error('Failed to unsend message');

                    // Remove bubble from DOM
                    const bubble = document.getElementById(`admin-msg-${messageId}`);
                    if (bubble) {
                        bubble.classList.add('opacity-0');
                        setTimeout(() => {
                            bubble.remove();
                        }, 250);
                    }

                    // Update left panel preview
                    const clientEl = document.querySelector(`.client-item[data-id="${activeClientId}"]`);
                    if (clientEl) {
                        const bodyEl = clientEl.querySelector('.last-msg-body');
                        if (bodyEl) {
                            bodyEl.textContent = 'Pesan ditarik';
                        }
                    }
                } catch (error) {
                    console.error('Error deleting message:', error);
                    Swal.fire(
                        'Gagal!',
                        'Gagal menarik pesan. Silakan coba lagi.',
                        'error'
                    );
                }
            }
        });
    });

    // Initialize Laravel Echo for Admin
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    // Listen on shared Admins Private Channel for messages
    window.Echo.private('admins')
        .listen('MessageSent', (e) => {
            const message = e;
            const senderId = message.sender_id;
            const senderName = message.sender_name || 'Pelanggan';

            // Jangan memproses pesan jika pengirimnya adalah diri sendiri (admin yang sedang login)
            if (parseInt(senderId) === currentUserId) return;

            // Ensure client exists in left sidebar
            ensureClientInList(senderId, senderName, '');

            if (activeClientId && parseInt(activeClientId) === parseInt(senderId)) {
                // If actively chatting with this client, append bubble
                appendMessage(message, 'client');
                scrollToBottom();
                
                // Call API to mark as read
                fetch(`/chat/messages/${senderId}`);
            } else {
                // If chatting with someone else or none, update unread count on left list item
                const clientEl = document.querySelector(`.client-item[data-id="${senderId}"]`);
                if (clientEl) {
                    const badge = clientEl.querySelector('.unread-badge');
                    if (badge) {
                        badge.classList.remove('d-none');
                        const curCount = parseInt(badge.textContent) || 0;
                        badge.textContent = curCount + 1;
                    }
                }

                // Play sound notification
                try {
                    const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-84.wav');
                    audio.volume = 0.4;
                    audio.play();
                } catch(e) {}
            }

            // Update text and timestamp on sidebar list
            updateClientListItem(senderId, message.message || '[Gambar]', message.created_at);
        })
        .listen('MessageDeleted', (e) => {
            const bubble = document.getElementById(`admin-msg-${e.message_id}`);
            if (bubble) {
                bubble.classList.add('opacity-0');
                setTimeout(() => {
                    bubble.remove();
                }, 250);
            }
        });
});
</script>

<style>
.chat-bubble-row {
    position: relative;
}
.chat-bubble-row .delete-btn {
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}
.chat-bubble-row:hover .delete-btn {
    opacity: 1 !important;
}
</style>
@endsection
