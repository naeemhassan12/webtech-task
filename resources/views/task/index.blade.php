@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold mb-1">Task Management</h3>
            <p class="text-muted mb-0">Track and manage project tasks and deadlines.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addTaskModal" id="addTaskBtnTop">
                <i data-lucide="plus-circle" style="width: 18px;"></i>
                <span>Add New Task</span>
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Task Info</th>
                            <th>Client Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        @foreach ($tasks as $task)
                            <tr id="taskRow{{ $task->id }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i data-lucide="layout" class="text-primary" style="width: 20px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $task->task_title }}</h6>
                                            <small class="text-muted">{{ $task->description }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $task->client_name }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            0 => 'secondary',
                                            1 => 'primary',
                                            2 => 'success',
                                            3 => 'danger',
                                            4 => 'warning'
                                        ];
                                        $statusColor = $statusColors[$task->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ $task_datas[$task->status] ?? 'Unknown' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">

                                        <button class="btn btn-sm btn-outline-primary btn-edit-task"
                                            data-id="{{ $task->id }}">
                                            <i data-lucide="edit-2" style="width: 14px;"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger deleteTaskBtn"
                                            data-id="{{ $task->id }}">
                                            <i data-lucide="trash-2" style="width: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Task</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addTaskForm">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Task Title</label>
                                <input type="text" name="tasksTitle" class="form-control"
                                    placeholder="e.g. Design System">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="clientsName" class="form-control" placeholder="e.g. John Doe">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <textarea class="form-control" name="TasksDescription" rows="3" placeholder="Describe the task details..."></textarea>
                        </div>
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="task_status">
                                    @foreach ($task_datas as $index => $task_data)
                                        <option value="{{ $index }}">{{ $task_data }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4" id="saveTaskBtn">Create Task</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Task Modal -->
   
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editTaskId" name="task_id">

                        <div class="mb-3">
                            <label>Task Title</label>
                            <input type="text" id="editTasksTitle" name="tasksTitle" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Client Name</label>
                            <input type="text" id="editClientsName" name="clientsName" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Task Description</label>
                            <textarea id="editTasksDescription" name="TasksDescription" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Status</label>
                                <select id="editStatus" name="status" class="form-select">
                                    @foreach ($task_datas as $index => $task_data)
                                        <option value="{{ $index }}">{{ $task_data }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateTaskBtn">Update Task</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

    <!-- Toast Notification Helper -->
    <script>
        function showToast(message, type = 'success') {
            const toastHTML = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0"
                     role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 300px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            const toastContainer = document.createElement('div');
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            toastContainer.innerHTML = toastHTML;
            document.body.appendChild(toastContainer);

            const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
            toast.show();

            setTimeout(() => toastContainer.remove(), 3000);
        }

        function renderIcons() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function getStatusBadgeColor(statusIndex) {
            const colors = {
                0: 'bg-secondary',
                1: 'bg-primary',
                2: 'bg-success',
                3: 'bg-danger',
                4: 'bg-warning'
            };
            return colors[statusIndex] || 'bg-secondary';
        }
    </script>

    <!-- AJAX Setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
    </script>

    <!-- Create Task AJAX -->
    <script>
        $(document).ready(function() {
            const addTaskModal = new bootstrap.Modal($('#addTaskModal')[0]);
            const taskStatuses = @json($task_datas);

            $('#saveTaskBtn').on('click', function(e) {
                e.preventDefault();

                let btn = $(this);
                let form = $('#addTaskForm');

                // Validation
                let taskTitle = form.find('input[name="tasksTitle"]').val().trim();
                let clientName = form.find('input[name="clientsName"]').val().trim();
                let description = form.find('textarea[name="TasksDescription"]').val().trim();
                let status = form.find('select[name="task_status"]').val();

                if (!taskTitle || !clientName || !description) {
                    showToast('Please fill all required fields', 'danger');
                    return;
                }

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span><span>Creating...</span>');

                $.ajax({
                    url: "{{ route('tasks.store') }}",
                    type: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        let statusText = taskStatuses[response.task.status] ?? 'Unknown';
                        let statusClass = getStatusBadgeColor(response.task.status);

                        let newRow = `
                            <tr id="taskRow${response.task.id}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i data-lucide="layout" class="text-primary" style="width: 20px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">${response.task.task_title}</h6>
                                            <small class="text-muted">${response.task.description}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>${response.task.client_name}</td>
                                <td>${response.task.description}</td>
                                <td><span class="badge ${statusClass}">${statusText}</span></td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-primary btn-edit-task" data-id="${response.task.id}">
                                            <i data-lucide="edit-2" style="width: 14px;"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger deleteTaskBtn" data-id="${response.task.id}">
                                            <i data-lucide="trash-2" style="width: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;

                        $('#taskTableBody').prepend(newRow);
                        renderIcons();

                        showToast(response.message, 'success');
                        btn.prop('disabled', false).html('<i data-lucide="plus-circle" style="width: 14px;"></i><span>Create Task</span>');
                        addTaskModal.hide();
                        form[0].reset();
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('<i data-lucide="plus-circle" style="width: 14px;"></i><span>Create Task</span>');
                        if (xhr.responseJSON?.errors) {
                            let errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            showToast(errorMsg, 'danger');
                        } else {
                            showToast(xhr.responseJSON?.message || 'Something went wrong!', 'danger');
                        }
                    }
                });
            });
        });
    </script>

    <!-- Edit Task AJAX -->
    <script>
        $(document).ready(function() {
            // Click event to load task data
            $(document).on('click', '.btn-edit-task', function() {
                let btn = $(this);
                let taskId = btn.data('id');

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: "/tasks/" + taskId + "/edit",
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        let task = response.task;

                        $('#editTaskId').val(task.id);
                        $('#editTasksTitle').val(task.task_title);
                        $('#editClientsName').val(task.client_name);
                        $('#editTasksDescription').val(task.description);
                        $('#editStatus').val(task.status);

                        btn.prop('disabled', false).html(
                            '<i data-lucide="edit-2" style="width: 14px;"></i>');
                        renderIcons();

                        // Show modal using Bootstrap API
                        const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                        modal.show();
                    },
                    error: function() {
                        btn.prop('disabled', false).html(
                            '<i data-lucide="edit-2" style="width: 14px;"></i>');
                        showToast('Failed to load task data', 'danger');
                    }
                });
            });
        });
    </script>

    <!-- Update Task AJAX -->
    <script>
        $(document).ready(function() {
            const taskStatuses = @json($task_datas);

            $('#updateTaskBtn').on('click', function(e) {
                e.preventDefault();

                let btn = $(this);
                let taskId = $('#editTaskId').val();
                let form = $('#editTaskForm');

                // Validation
                let taskTitle = form.find('input[name="tasksTitle"]').val().trim();
                let clientName = form.find('input[name="clientsName"]').val().trim();
                let description = form.find('textarea[name="TasksDescription"]').val().trim();

                if (!taskTitle || !clientName || !description) {
                    showToast('Please fill all required fields', 'danger');
                    return;
                }

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span><span>Saving...</span>');

                $.ajax({
                    url: "/tasks/" + taskId,
                    type: "POST",
                    data: form.serialize() + '&_method=PUT',
                    success: function(response) {
                        let task = response.task;
                        let statusText = taskStatuses[task.status] ?? 'Unknown';
                        let statusClass = getStatusBadgeColor(task.status);

                        // Update table row with AJAX
                        let row = $(`
                            <tr id="taskRow${task.id}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i data-lucide="layout" class="text-primary" style="width: 20px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">${task.task_title}</h6>
                                            <small class="text-muted">${task.description}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>${task.client_name}</td>
                                <td>${task.description}</td>
                                <td>
                                    <span class="badge ${statusClass}">${statusText}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-primary btn-edit-task" data-id="${task.id}">
                                            <i data-lucide="edit-2" style="width: 14px;"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger deleteTaskBtn" data-id="${task.id}">
                                            <i data-lucide="trash-2" style="width: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `);

                        $('#taskRow' + taskId).replaceWith(row);

                        renderIcons();

                        // Close modal properly using Bootstrap API
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
                        if (modal) {
                            modal.hide();
                        }

                        btn.prop('disabled', false).html('<i data-lucide="save" style="width: 14px;"></i><span>Update Task</span>');
                        showToast('Task updated successfully!', 'success');
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('<i data-lucide="save" style="width: 14px;"></i><span>Update Task</span>');
                        if (xhr.responseJSON?.errors) {
                            let errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            showToast(errorMsg, 'danger');
                        } else {
                            showToast(xhr.responseJSON?.message || 'Failed to update task', 'danger');
                        }
                    }
                });
            });
        });
    </script>

    <!-- Delete Task AJAX -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteTaskBtn', function() {
                let btn = $(this);
                let taskId = btn.data('id');

                if (!confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                    return;
                }

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: "/tasks/" + taskId,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#taskRow' + taskId).fadeOut(300, function() {
                            $(this).remove();
                            showToast('Task deleted successfully!', 'success');
                        });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(
                            '<i data-lucide="trash-2" style="width: 14px;"></i>');
                        let errorMsg = xhr.responseJSON?.message || 'Failed to delete task';
                        showToast(errorMsg, 'danger');
                    }
                });
            });
        });
    </script>

    <!-- Initialize Lucide Icons on page load -->
    <script>
        $(document).ready(function() {
            renderIcons();
        });
    </script>

@endsection
