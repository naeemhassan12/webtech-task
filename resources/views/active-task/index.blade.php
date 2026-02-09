@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded shadow-sm bg-white">
            <div class="d-flex flex-column">
                {{-- <h5 class="fw-bold mb-2 text-primary">Active Task</h5> --}}
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
                {{-- fetch the data from user table --}}
                <div class="d-flex flex-wrap align-items-center gap-1" id="task-members-container">
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

    {{-- model  --}}

    <div class="modal fade" id="memberManageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Member Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
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


    <script type="module">
        import { addUserTaskToFirebase, removeUserTaskFromFirebase } from '/js/firebase-config.js';

        document.addEventListener('click', async function(e) {
            if (!e.target.classList.contains('member-btn')) return;

            const btn = e.target;
            const userId = btn.dataset.userId;
            const userName = btn.dataset.userName;
            const taskId = btn.dataset.taskId;
            const isAdded = btn.dataset.added === '1';

            // Disable button during request
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
                    
                    // Get task details for Firebase
                    const taskTitle = '{{ $activeTasks->task_title ?? "" }}';
                    const clientName = '{{ $activeTasks->client_name ?? "" }}';

                    if (isAdded) {
                        // REMOVE from Firebase
                        await removeUserTaskFromFirebase(userId, userName, taskId, 'active');

                        // REMOVE UI update
                        btn.className = 'btn btn-sm btn-outline-success member-btn';
                        btn.innerText = 'Add';
                        btn.dataset.added = '0';

                        // Remove from background list
                        const memberSpan = container.querySelector(`.member-item[data-id="${userId}"]`);
                        if (memberSpan) {
                            // Check if next sibling is a separator and remove it
                            if (memberSpan.nextElementSibling && memberSpan.nextElementSibling.classList
                                .contains('separator')) {
                                memberSpan.nextElementSibling.remove();
                            } else if (memberSpan.previousElementSibling && memberSpan
                                .previousElementSibling.classList.contains('separator')) {
                                // Or if it was the last one, remove previous separator
                                memberSpan.previousElementSibling.remove();
                            }
                            memberSpan.remove();
                        }

                        if (container.children.length === 0) {
                            container.innerHTML =
                                '<span class="text-muted no-members">No members assigned</span>';
                        }

                        showToast(data.message || `${userName} removed successfully`, 'danger');
                    } else {
                        // ADD to Firebase
                        await addUserTaskToFirebase(userId, userName, taskId, 'active', taskTitle, clientName);

                        // ADD UI update
                        btn.className = 'btn btn-sm btn-outline-danger member-btn';
                        btn.innerText = 'Remove';
                        btn.dataset.added = '1';

                        // Add to background list
                        const noMembersParams = container.querySelector('.no-members');
                        if (noMembersParams) noMembersParams.remove();

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

                        showToast(data.message || `${userName} added successfully`);
                    }
                } else {
                    showToast('Action failed', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Something went wrong', 'danger');
            } finally {
                btn.disabled = false;
            }
        });

        // Toast
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
            toast.style.zIndex = 1055;
            toast.innerText = message;

            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        }
    </script>




    {{-- Chat Interface --}}

    <style>
        body {
            background: #e5ddd5;
        }

        .chat-card {
            max-width: 100%;
            margin: 20px auto;
            background: #f7f7f7;
            border-radius: 15px;
        }

        .chat-header {
            background: #34b7f1;
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            font-weight: 600;
        }

        .chat-body {
            height: 450px;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message {
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 75%;
            word-wrap: break-word;
        }

        .sent {
            background: #dcf8c6;
            align-self: flex-end;
        }

        .received {
            background: #fff;
            align-self: flex-start;
        }

        .chart-bubble {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .input-group {
            margin: 10px auto;
            max-width: 97%;
        }
    </style>


    <div class="chat-card shadow">
        <div class="chat-header">
             <strong>dashboard3</strong> | Client: <strong>mobin</strong>
        </div>
        <div class="chat-body" id="chatBody"></div>
    </div>
    <div class="input-group">
        <input type="text" id="msgInput" class="form-control rounded-pill" placeholder="Type a message...">
        <button id="sendBtn" class="btn btn-primary rounded-pill">Send</button>
    </div>

    <script type="module">
        import { sendChatMessage, listenToChatMessages } from '/js/firebase-config.js';

        const chatBody = document.getElementById('chatBody');
        const taskId = '{{ $activeTasks->id ?? "" }}';
        const currentUserId = '{{ auth()->user()->id ?? "" }}';
        const currentUserName = '{{ auth()->user()->name ?? "Guest" }}';

        // Store displayed message IDs to prevent duplicates
        let displayedMessages = new Set();

        function appendMessage(messageData) {
            // Prevent duplicate messages
            if (displayedMessages.has(messageData.messageId)) {
                return;
            }
            displayedMessages.add(messageData.messageId);

            const msgDiv = document.createElement('div');
            const isCurrentUser = messageData.userId == currentUserId;
            msgDiv.classList.add('message', isCurrentUser ? 'sent' : 'received');
            
            // Format timestamp
            const timestamp = new Date(messageData.timestamp);
            const timeString = timestamp.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            msgDiv.innerHTML = `
                <div style="display: flex; flex-direction: column;">
                    <div><strong>${messageData.userName}:</strong> ${escapeHtml(messageData.message)}</div>
                    <div style="font-size: 0.75rem; color: #888; margin-top: 2px;">${timeString}</div>
                </div>
            `;
            
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
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

        // Listen to real-time messages from Firebase
        if (taskId) {
            listenToChatMessages(taskId, (messages) => {
                clearChat();
                messages.forEach(msg => appendMessage(msg));
            });
        }

        // Send message
        async function sendMessage() {
            const text = document.getElementById('msgInput').value.trim();
            if (!text || !taskId) return;

            // Clear input immediately for better UX
            document.getElementById('msgInput').value = '';

            // Send to Firebase
            const success = await sendChatMessage(taskId, currentUserId, currentUserName, text);
            
            if (!success) {
                // Show error toast if sending failed
                showToast('Failed to send message', 'danger');
                // Restore message in input
                document.getElementById('msgInput').value = text;
            }
        }

        document.getElementById('sendBtn').addEventListener('click', sendMessage);

        // Send on Enter key
        document.getElementById('msgInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
                e.preventDefault();
            }
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
            toast.style.zIndex = 1055;
            toast.innerText = message;

            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        }
    </script>
@endsection
