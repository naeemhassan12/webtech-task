@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h3 class="fw-bold mb-1">User Management</h3>
        <p class="text-muted mb-0">Manage your system users and their permissions.</p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i data-lucide="user-plus" style="width: 18px;"></i>
            <span>Add New User</span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User Details</th>
                        <th>Email Address</th>
                        <th>Created Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Ali Khan</h6>
                                    <small class="text-muted">Administrator</small>
                                </div>
                            </div>
                        </td>
                        <td>ali@gmail.com</td>
                        <td>Jan 24, 2024</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="edit-2" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Ahmed Raza</h6>
                                    <small class="text-muted">Editor</small>
                                </div>
                            </div>
                        </td>
                        <td>ahmed@gmail.com</td>
                        <td>Jan 22, 2024</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="edit-2" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Sara Ali</h6>
                                    <small class="text-muted">Viewer</small>
                                </div>
                            </div>
                        </td>
                        <td>sara@gmail.com</td>
                        <td>Jan 20, 2024</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary"><i data-lucide="edit-2" style="width: 14px;"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add New User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New User</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action ="{{ route('user.store') }}" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i data-lucide="user" style="width: 16px;"></i></span>
                            <input type="text" name="username" class="form-control border-start-0" placeholder="Enter full name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i data-lucide="mail" style="width: 16px;"></i></span>
                            <input type="email" name="email" class="form-control border-start-0" placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 text-start">
                            <label class="form-label">Username</label>
                            <input type="text" name="name" class="form-control" placeholder="username">
                        </div>
                        <div class="col-md-6 text-start">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option>Administrator</option>
                                <option>Editor</option>
                                <option>Viewer</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i data-lucide="lock" style="width: 16px;"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="Create a password">
                        </div>
                        <small class="text-muted">Must be at least 8 characters</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="saveUserBtn">Create User</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        const saveUserBtn = document.getElementById('saveUserBtn');
        const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));

        saveUserBtn.addEventListener('click', function() {
            // Static demo effect
            saveUserBtn.disabled = true;
            saveUserBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';

            setTimeout(() => {
                alert('User created successfully!');
                saveUserBtn.disabled = false;
                saveUserBtn.innerHTML = 'Create User';
                addUserModal.hide();
                document.getElementById('addUserForm').reset();
            }, 1000);
        });
    });
</script>
@endsection
