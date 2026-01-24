@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h3 class="fw-bold mb-1">Task Management</h3>
        <p class="text-muted mb-0">Track and manage project tasks and deadlines.</p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addTaskModal">
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
                        <th>Client</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i data-lucide="layout" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Website Design</h6>
                                    <small class="text-muted">Create homepage UI</small>
                                </div>
                            </div>
                        </td>
                        <td>Ali Khan</td>
                        <td><span class="badge bg-light text-secondary border">Pending</span></td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="eye" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i data-lucide="code" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">API Integration</h6>
                                    <small class="text-muted">Payment gateway</small>
                                </div>
                            </div>
                        </td>
                        <td>Ahmed Raza</td>
                        <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">Active</span></td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="eye" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i data-lucide="check-circle" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Project Delivery</h6>
                                    <small class="text-muted">Final deployment</small>
                                </div>
                            </div>
                        </td>
                        <td>Hassan Ali</td>
                        <td><span class="badge bg-success-subtle text-success border border-success-subtle">Completed</span></td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="eye" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
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
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Task Title</label>
                            <input type="text" class="form-control" placeholder="e.g. Design System">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Client Name</label>
                            <input type="text" class="form-control" placeholder="e.g. John Doe">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Task Description</label>
                        <textarea class="form-control" rows="3" placeholder="Describe the task details..."></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <select class="form-select">
                                <option>Low</option>
                                <option selected>Medium</option>
                                <option>High</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option value="0">Pending</option>
                                <option value="1">Active</option>
                                <option value="2">Completed</option>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        const saveTaskBtn = document.getElementById('saveTaskBtn');
        const addTaskModal = new bootstrap.Modal(document.getElementById('addTaskModal'));

        saveTaskBtn.addEventListener('click', function() {
            saveTaskBtn.disabled = true;
            saveTaskBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
            
            setTimeout(() => {
                alert('Task added successfully!');
                saveTaskBtn.disabled = false;
                saveTaskBtn.innerHTML = 'Create Task';
                addTaskModal.hide();
                document.getElementById('addTaskForm').reset();
            }, 1000);
        });
    });
</script>
@endsection
