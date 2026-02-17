@extends('layouts.app')

@section('content')
    <div class="row mb-3 align-items-center">
        <div class="d-flex justify-content-between align-items-center p-3 border rounded shadow-sm bg-white">
            <div class="d-flex flex-column">
                @if ($activeTasks)
                    <div class="d-flex flex-row align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-truncate" style="max-width: 250px;">
                            {{ $activeTasks->task_title }}
                        </span>
                        <span class="text-muted">
                            {{ $activeTasks->client_name }}
                        </span>
                    </div>
                @else
                    <span class="text-muted">No active task available</span>
                @endif
                <div class="d-flex flex-wrap align-items-center gap-1 mt-2" id="task-members-container">
                    @forelse ($activeTasks->users as $user)
                        <span class="member-item" data-id="{{ $user->id }}">{{ $user->name }}</span>
                        @if (!$loop->last)
                            <span class="text-muted separator">.</span>
                        @endif
                    @empty
                        <span class="text-muted no-members">No members assigned</span>
                    @endforelse
                </div>
            </div>
            <div class="d-flex align-items-start ms-3">
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                    <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-3"
                        data-bs-toggle="modal" data-bs-target="#memberManageModal">
                        <i data-lucide="plus" style="width: 18px;"></i>
                        <span>Member Manage</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
    {{-- Professional Chat Interface --}}
    <div class="chat-application">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar-header">
                    <div class="avatar-status-wrapper">
                        <div class="chat-avatar-circle">
                            {{ strtoupper(substr($activeTasks->task_title ?? 'TK', 0, 2)) }}
                        </div>
                        <span class="status-indicator online"></span>
                    </div>
                </div>
                <div class="chat-header-details">
                    <h3 class="chat-title">{{ $activeTasks->task_title ?? 'Task Discussion' }}</h3>
                    <p class="chat-status">
                        <span class="typing-indicator" style="display: none;">
                            <span></span><span></span><span></span>
                        </span>
                        <span class="online-status">{{ $activeTasks->client_name ?? 'Active now' }}</span>
                    </p>
                </div>
            </div>
            <div class="chat-header-actions">
                <button class="chat-action-btn" title="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="currentColor"/>
                    </svg>
                </button>
                <button class="chat-action-btn" title="More options">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Body -->
        <div class="chat-body-wrapper">
            <div id="chatBody" class="chat-body-professional">
                <!-- Messages will be appended here dynamically -->
            </div>
        </div>

        <!-- Chat Input Area -->
        <div class="chat-input-wrapper">
            <div class="chat-input-container">
                <button class="chat-attach-btn" title="Attach file">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z" fill="currentColor"/>
                    </svg>
                </button>
                <div class="chat-input-field-wrapper">
                    <input
                        type="text"
                        id="msgInput"
                        class="chat-input-field"
                        placeholder="Type a message..."
                        autocomplete="off"
                    />
                    <button class="chat-emoji-btn" title="Emoji">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
                <button id="sendBtn" class="chat-send-btn" title="Send message">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    {{-- Member Management Modal --}}
    <div class="modal fade" id="memberManageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Member Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Member Name</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @php
                                        $isAdded = in_array($user->id, $taskMembers ?? []);
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $user->name }}</td>
                                        <td class="text-end">
                                            <button
                                                class="btn btn-sm {{ $isAdded ? 'btn-outline-danger' : 'btn-outline-success' }} member-btn"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                data-task-id="{{ $activeTasks->id }}"
                                                data-added="{{ $isAdded ? '1' : '0' }}">
                                                {{ $isAdded ? 'Remove' : 'Add' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Audio notification --}}
    <audio id="notifSound">
        <source src="/sounds/notification.mp3" type="audio/mpeg">
    </audio>
    {{-- Member Management Script --}}
    <script type="module">
        import {
            addUserTaskToFirebase,
            removeUserTaskFromFirebase
        } from '/js/firebase-config.js';

        document.addEventListener('click', async function(e) {
            if (!e.target.classList.contains('member-btn')) return;

            const btn = e.target;
            const userId = btn.dataset.userId;
            const userName = btn.dataset.userName;
            const taskId = btn.dataset.taskId;
            const isAdded = btn.dataset.added === '1';

            btn.disabled = true;

            const url = isAdded ?
                `/active/${taskId}/remove-member/${userId}` :
                `/active/${taskId}/add-member/${userId}`;

            const method = isAdded ? 'DELETE' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const container = document.getElementById('task-members-container');
                    const taskTitle = '{{ $activeTasks->task_title ?? '' }}';
                    const clientName = '{{ $activeTasks->client_name ?? '' }}';

                    if (isAdded) {
                        await removeUserTaskFromFirebase(userId, userName, taskId, 'active');
                        btn.className = 'btn btn-sm btn-outline-success member-btn';
                        btn.innerText = 'Add';
                        btn.dataset.added = '0';

                        const memberSpan = container.querySelector(`.member-item[data-id="${userId}"]`);
                        if (memberSpan) {
                            if (memberSpan.nextElementSibling?.classList.contains('separator')) {
                                memberSpan.nextElementSibling.remove();
                            } else if (memberSpan.previousElementSibling?.classList.contains('separator')) {
                                memberSpan.previousElementSibling.remove();
                            }
                            memberSpan.remove();
                        }

                        if (container.children.length === 0) {
                            container.innerHTML = '<span class="text-muted no-members">No members assigned</span>';
                        }

                        showMemberToast(data.message || `${userName} removed successfully`, 'danger');
                    } else {
                        await addUserTaskToFirebase(userId, userName, taskId, 'active', taskTitle, clientName);
                        btn.className = 'btn btn-sm btn-outline-danger member-btn';
                        btn.innerText = 'Remove';
                        btn.dataset.added = '1';

                        const noMembers = container.querySelector('.no-members');
                        if (noMembers) noMembers.remove();

                        if (container.children.length > 0) {
                            const separator = document.createElement('span');
                            separator.className = 'text-muted separator';
                            separator.innerText = '.';
                            container.appendChild(separator);
                        }

                        const newMember = document.createElement('span');
                        newMember.className = 'member-item';
                        newMember.dataset.id = userId;
                        newMember.innerText = userName;
                        container.appendChild(newMember);

                        showMemberToast(data.message || `${userName} added successfully`);
                    }
                } else {
                    showMemberToast('Action failed', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showMemberToast('Something went wrong', 'danger');
            } finally {
                btn.disabled = false;
            }
        });

        function showMemberToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
            toast.style.zIndex = 1055;
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }
    </script>
    {{-- Professional Chat Script --}}
    <script type="module">
        import {
            sendChatMessage,
            listenToChatMessages
        } from '/js/firebase-config.js';

        const chatBody = document.getElementById('chatBody');
        const taskId = '{{ $activeTasks->id ?? '' }}';
        const currentUserId = '{{ auth()->user()->id ?? '' }}';
        const currentUserName = '{{ auth()->user()->name ?? 'Guest' }}';

        let displayedMessages = new Set();
        let notifiedMessages = new Set();
        let isUserScrolling = false;
        let scrollTimeout;

        chatBody.addEventListener('scroll', () => {
            const isAtBottom = chatBody.scrollHeight - chatBody.scrollTop <= chatBody.clientHeight + 50;
            isUserScrolling = !isAtBottom;

            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (isAtBottom) isUserScrolling = false;
            }, 150);
        });

        function appendMessage(messageData) {
            if (displayedMessages.has(messageData.messageId)) return;
            displayedMessages.add(messageData.messageId);

            const msgDiv = document.createElement('div');
            const isCurrentUser = messageData.userId == currentUserId;
            msgDiv.classList.add('message-wrapper-pro', isCurrentUser ? 'sent' : 'received');

            const timestamp = new Date(messageData.timestamp);
            const timeString = timestamp.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit'
            });

            const initials = messageData.userName.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);

            msgDiv.innerHTML = `
                <div class="message-container-pro ${isCurrentUser ? 'message-sent-pro' : 'message-received-pro'}">
                    ${!isCurrentUser ? `
                        <div class="message-avatar-pro">
                            <div class="avatar-circle-pro">${initials}</div>
                        </div>
                    ` : ''}
                    <div class="message-content-pro">
                        <div class="message-bubble-pro">
                            <p class="message-text-pro">${escapeHtml(messageData.message)}</p>
                            <div class="message-meta-pro">
                                <span class="message-time-pro">${timeString}</span>
                                ${isCurrentUser ? `
                                    <span class="message-status-pro">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.5 8.5L7.5 10.5L11.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.5 8.5L10.5 10.5L14.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                ` : ''}
                            </div>
                        </div>
                        ${!isCurrentUser ? `<div class="message-sender-name-pro">${messageData.userName}</div>` : ''}
                    </div>
                    ${isCurrentUser ? `
                        <div class="message-avatar-pro">
                            <div class="avatar-circle-pro avatar-current-pro">${initials}</div>
                        </div>
                    ` : ''}
                </div>
            `;

            chatBody.appendChild(msgDiv);

            if (!isUserScrolling) {
                setTimeout(() => {
                    chatBody.scrollTo({
                        top: chatBody.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 50);
            }

            setTimeout(() => {
                msgDiv.classList.add('message-appear-pro');
            }, 10);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function clearChat() {
            chatBody.innerHTML = '';
            displayedMessages.clear();
        }

        function addDateSeparator(date) {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);

            let dateText;
            if (date.toDateString() === today.toDateString()) {
                dateText = 'Today';
            } else if (date.toDateString() === yesterday.toDateString()) {
                dateText = 'Yesterday';
            } else {
                dateText = date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: date.getFullYear() !== today.getFullYear() ? 'numeric' : undefined
                });
            }

            const separator = document.createElement('div');
            separator.className = 'date-separator-pro';
            separator.innerHTML = `<span>${dateText}</span>`;
            chatBody.appendChild(separator);
        }

        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }

        if (taskId) {
            listenToChatMessages(taskId, (messages) => {
                clearChat();

                let lastDate = null;
                messages.forEach(msg => {
                    const msgDate = new Date(msg.timestamp);
                    const msgDateStr = msgDate.toDateString();

                    if (lastDate !== msgDateStr) {
                        addDateSeparator(msgDate);
                        lastDate = msgDateStr;
                    }

                    appendMessage(msg);

                    if (msg.userId != currentUserId && !notifiedMessages.has(msg.messageId)) {
                        showChatNotification(msg.userName, msg.message);
                        notifiedMessages.add(msg.messageId);
                    }
                });
            });
        }

        async function sendMessage() {
            const input = document.getElementById('msgInput');
            const text = input.value.trim();
            if (!text || !taskId) return;

            input.value = '';
            input.focus();

            showTypingIndicator();

            const success = await sendChatMessage(
                taskId,
                currentUserId,
                currentUserName,
                text
            );

            hideTypingIndicator();

            if (!success) {
                showProfessionalToast('Failed to send message', 'error');
                input.value = text;
            }
        }

        function showTypingIndicator() {
            document.querySelector('.typing-indicator').style.display = 'inline-flex';
            document.querySelector('.online-status').style.display = 'none';
        }

        function hideTypingIndicator() {
            setTimeout(() => {
                document.querySelector('.typing-indicator').style.display = 'none';
                document.querySelector('.online-status').style.display = 'inline';
            }, 500);
        }

        document.getElementById('sendBtn').addEventListener('click', sendMessage);

        document.getElementById('msgInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                sendMessage();
                e.preventDefault();
            }
        });

        const msgInput = document.getElementById('msgInput');
        msgInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        function showChatNotification(sender, message) {
            const sound = document.getElementById('notifSound');
            if (sound) sound.play();

            showProfessionalToast(message, 'message', sender);

            if (Notification.permission === "granted") {
                new Notification("New Message", {
                    body: `${sender}: ${message}`,
                    icon: "/logo.png",
                    badge: "/logo.png",
                    tag: 'chat-notification',
                    requireInteraction: false
                });
            }
        }

        function showProfessionalToast(message, type = 'success', sender = null) {
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.className = 'notification-container';
                document.body.appendChild(container);
            }

            const notification = document.createElement('div');
            notification.className = `notification-card notification-${type}`;

            const config = getNotificationConfig(type);
            const initials = sender ? sender.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2) : '';

            notification.innerHTML = `
                <div class="notification-icon-wrapper">
                    ${sender ? `
                        <div class="notification-avatar">${initials}</div>
                    ` : `
                        <div class="notification-icon">
                            ${config.icon}
                        </div>
                    `}
                </div>
                <div class="notification-content">
                    <div class="notification-title">${config.title}</div>
                    ${sender ? `<div class="notification-sender">${sender}</div>` : ''}
                    <div class="notification-message">${escapeHtml(message)}</div>
                    <div class="notification-time">Just now</div>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="currentColor"/>
                    </svg>
                </button>
                <div class="notification-progress"></div>
            `;

            container.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('notification-show');
            }, 10);

            setTimeout(() => {
                notification.classList.add('notification-hide');
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        function getNotificationConfig(type) {
            const configs = {
                message: {
                    title: 'New Message',
                    icon: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M20 2H4C2.9 2 2.01 2.9 2.01 4L2 22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM18 14H6V12H18V14ZM18 11H6V9H18V11ZM18 8H6V6H18V8Z" fill="currentColor"/>
                    </svg>`
                },
                error: {
                    title: 'Error',
                    icon: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                    </svg>`
                }
            };
            return configs[type] || configs.message;
        }
    </script>
    {{-- Professional Chat Styles with Dynamic Width --}}
    <style>
        /* Member Item Styles */
        .member-item {
            display: inline-block;
            padding: 4px 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        }

        .separator {
            font-size: 14px;
            margin: 0 4px;
        }

        /* ========== CHAT APPLICATION CONTAINER ========== */
        .chat-application {
            display: flex;
            flex-direction: column;
            height: 600px;
            background: #f0f2f5;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* ========== CHAT HEADER ========== */
        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .chat-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .avatar-status-wrapper {
            position: relative;
        }

        .chat-avatar-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #667eea;
            background: #10b981;
        }

        .status-indicator.online {
            animation: pulse-status 2s infinite;
        }

        @keyframes pulse-status {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            50% { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0); }
        }

        .chat-header-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .chat-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: white;
            letter-spacing: -0.2px;
        }

        .chat-status {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .typing-indicator {
            display: inline-flex;
            gap: 3px;
            align-items: center;
        }

        .typing-indicator span {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            animation: typing-bounce 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing-bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-6px); }
        }

        .chat-header-actions {
            display: flex;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .chat-action-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .chat-action-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        /* ========== CHAT BODY ========== */
        .chat-body-wrapper {
            flex: 1;
            overflow: hidden;
            background: #e5ddd5;
            position: relative;
        }

        .chat-body-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,0,0,0.02) 10px, rgba(0,0,0,0.02) 20px);
            pointer-events: none;
        }

        .chat-body-professional {
            height: 100%;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .chat-body-professional::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body-professional::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-body-professional::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .chat-body-professional::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        .date-separator-pro {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 16px 0;
        }

        .date-separator-pro span {
            background: rgba(255, 255, 255, 0.9);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #667eea;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* ========== MESSAGE STYLES WITH DYNAMIC WIDTH ========== */
        .message-wrapper-pro {
            margin-bottom: 4px;
            opacity: 0;
            transform: translateY(10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            width: 100%;
        }

        .message-wrapper-pro.message-appear-pro {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .message-container-pro {
            display: inline-flex;
            gap: 8px;
            align-items: flex-end;
            max-width: 75%;
            min-width: 120px;
            width: fit-content;
        }

        .message-container-pro.message-sent-pro {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .message-container-pro.message-received-pro {
            margin-right: auto;
        }

        .message-avatar-pro {
            flex-shrink: 0;
        }

        .avatar-circle-pro {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            transition: transform 0.2s ease;
        }

        .avatar-circle-pro.avatar-current-pro {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .avatar-circle-pro:hover {
            transform: scale(1.1);
        }

        .message-content-pro {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
            width: fit-content;
        }

        .message-sender-name-pro {
            font-size: 11px;
            color: #667eea;
            font-weight: 600;
            padding: 0 8px;
            margin-top: 2px;
        }

        .message-bubble-pro {
            position: relative;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            width: fit-content;
            min-width: 60px;
            max-width: 100%;
            word-wrap: break-word;
        }

        .message-received-pro .message-bubble-pro {
            background: white;
            border-top-left-radius: 0;
        }

        .message-sent-pro .message-bubble-pro {
            background: #dcf8c6;
            border-top-right-radius: 0;
        }

        .message-bubble-pro:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .message-received-pro .message-bubble-pro::before {
            content: '';
            position: absolute;
            top: 0;
            left: -8px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 8px 8px 0;
            border-color: transparent white transparent transparent;
        }

        .message-sent-pro .message-bubble-pro::before {
            content: '';
            position: absolute;
            top: 0;
            right: -8px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 8px 8px 0 0;
            border-color: #dcf8c6 transparent transparent transparent;
        }

        .message-text-pro {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: #111;
            word-wrap: break-word;
            white-space: pre-wrap;
            display: inline-block;
        }

        .message-meta-pro {
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: flex-end;
            margin-top: 4px;
            white-space: nowrap;
        }

        .message-time-pro {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.45);
            font-weight: 500;
        }

        .message-status-pro {
            display: flex;
            align-items: center;
            color: #34b7f1;
        }

        /* ========== CHAT INPUT ========== */
        .chat-input-wrapper {
            background: #f0f2f5;
            padding: 12px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chat-input-container {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            background: white;
            border-radius: 24px;
            padding: 8px 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .chat-attach-btn,
        .chat-emoji-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
            color: #667eea;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .chat-attach-btn:hover,
        .chat-emoji-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.1);
        }

        .chat-input-field-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .chat-input-field {
            flex: 1;
            border: none;
            outline: none;
            font-size: 15px;
            color: #111;
            background: transparent;
            resize: none;
            max-height: 120px;
            overflow-y: auto;
            font-family: inherit;
            line-height: 1.5;
        }

        .chat-input-field::placeholder {
            color: #999;
        }

        .chat-send-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .chat-send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .chat-send-btn:active {
            transform: scale(0.95);
        }

        /* ========== NOTIFICATION STYLES ========== */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 420px;
            pointer-events: none;
        }

        .notification-card {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            opacity: 0;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            pointer-events: all;
            overflow: hidden;
            backdrop-filter: blur(10px);
            min-width: 360px;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            pointer-events: none;
        }

        .notification-card.notification-show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification-card.notification-hide {
            opacity: 0;
            transform: translateX(400px) scale(0.9);
        }

        .notification-message {
            border-left-color: #667eea;
        }

        .notification-message .notification-icon-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .notification-error {
            border-left-color: #ef4444;
        }

        .notification-error .notification-icon-wrapper {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .notification-icon-wrapper {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .notification-icon-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-30%, -30%) rotate(180deg); }
        }

        .notification-icon svg {
            position: relative;
            z-index: 1;
        }

        .notification-avatar {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-weight: 700;
            font-size: 15px;
            color: #1a202c;
            margin-bottom: 4px;
            letter-spacing: -0.2px;
        }

        .notification-sender {
            font-weight: 600;
            font-size: 13px;
            color: #667eea;
            margin-bottom: 6px;
        }

        .notification-message {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 6px;
            word-wrap: break-word;
        }

        .notification-time {
            font-size: 12px;
            color: #a0aec0;
            font-weight: 500;
        }

        .notification-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 28px;
            height: 28px;
            border: none;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .notification-close:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #2d3748;
            transform: rotate(90deg);
        }

        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            animation: progress 4s linear;
            border-radius: 0 0 0 8px;
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* ========== RESPONSIVE DESIGN ========== */
        @media (max-width: 768px) {
            .chat-application {
                border-radius: 0;
                height: 500px;
            }

            .message-container-pro {
                max-width: 85%;
            }

            .notification-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }

            .notification-card {
                min-width: auto;
            }
        }
    </style>
@endsection
