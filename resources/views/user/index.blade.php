@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold mb-1">User Management</h3>
            <p class="text-muted mb-0">Manage your system users and their permissions.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addUserModal" id="addUserBtnTop">
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
                            <th>Role</th>
                            <th>Created Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr id="userRow{{ $user->id }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                            <small class="text-muted">Administrator</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    @php
                                        $roleColors = [
                                            'superadmin' => 'danger',
                                            'admin' => 'warning',
                                            'user' => 'info'
                                        ];
                                        $roleColor = $roleColors[$user->role] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-primary editUserBtn" data-id="{{ $user->id }}">
                                            <i data-lucide="edit-2" style="width: 14px;"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger deleteUserBtn"
                                            data-id="{{ $user->id }}">
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

    <!-- Add New User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New User</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i data-lucide="user"
                                        style="width: 16px;"></i></span>
                                <input type="text" name="name" class="form-control border-start-0"
                                    placeholder="Enter full name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i data-lucide="mail"
                                        style="width: 16px;"></i></span>
                                <input type="email" name="email" class="form-control border-start-0"
                                    placeholder="Enter email address">
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{-- <div class="col-md-6 text-start">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username">
                            </div> --}}
                            <div class="col-md-12 text-start">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i data-lucide="lock"
                                        style="width: 16px;"></i></span>
                                <input type="password" name="password" class="form-control border-start-0"
                                    placeholder="Create a password">
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

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit User</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editUserForm">
                        @csrf
                        <input type="hidden" name="user_id" id="editUserId">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i data-lucide="user" style="width: 16px;"></i>
                                </span>
                                <input type="text" name="name" id="editUserName"
                                    class="form-control border-start-0" placeholder="Enter full name">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i data-lucide="mail" style="width: 16px;"></i>
                                </span>
                                <input type="email" name="email" id="editUserEmail"
                                    class="form-control border-start-0" placeholder="Enter email address">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" id="editUserRole">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4" id="updateUserBtn">Save Changes</button>
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
    </script>

    <!-- AJAX Setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
    </script>

    <!-- Create User AJAX -->
    <script>
        $('#saveUserBtn').click(function() {
            let btn = $(this);
            let form = $('#addUserForm');

            // Validation
            let name = form.find('input[name="name"]').val().trim();
            let email = form.find('input[name="email"]').val().trim();
            let password = form.find('input[name="password"]').val().trim();

            if (!name || !email || !password) {
                showToast('Please fill all required fields', 'danger');
                return;
            }

            btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span><span>Creating...</span>');

            $.ajax({
                url: '{{ route('user.store') }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Add new row to table
                    let roleColorMap = { 'superadmin': 'danger', 'admin': 'warning', 'user': 'info' };
                    let roleColor = roleColorMap[response.user.role] || 'secondary';

                    let newRow = `
                        <tr id="userRow${response.user.id}">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">${response.user.name}</h6>
                                        <small class="text-muted">Administrator</small>
                                    </div>
                                </div>
                            </td>
                            <td>${response.user.email}</td>
                            <td><span class="badge bg-${roleColor}">${response.user.role.charAt(0).toUpperCase() + response.user.role.slice(1)}</span></td>
                            <td>${new Date(response.user.created_at).toLocaleDateString()}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-primary editUserBtn" data-id="${response.user.id}">
                                        <i data-lucide="edit-2" style="width: 14px;"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger deleteUserBtn" data-id="${response.user.id}">
                                        <i data-lucide="trash-2" style="width: 14px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;

                    $('table tbody').prepend(newRow);
                    renderIcons();

                    showToast(response.message, 'success');
                    btn.prop('disabled', false).html('<i data-lucide="user-plus" style="width: 14px;"></i><span>Create User</span>');
                    $('#addUserModal').modal('hide');
                    form[0].reset();
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i data-lucide="user-plus" style="width: 14px;"></i><span>Create User</span>');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = Object.values(errors).flat().join('\n');
                        showToast(errorMsg, 'danger');
                    } else {
                        showToast('Something went wrong. Try again!', 'danger');
                    }
                }
            });
        });
    </script>

    <!-- Edit User AJAX -->
    <script>
        $(document).on('click', '.editUserBtn', function() {
            let btn = $(this);
            let userId = btn.data('id');

            btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: '/user/' + userId + '/edit',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#editUserId').val(response.user.id);
                    $('#editUserName').val(response.user.name);
                    $('#editUserEmail').val(response.user.email);
                    $('#editUserRole').val(response.user.role);
                    $('#editUserPassword').val('');

                    btn.prop('disabled', false).html(
                        '<i data-lucide="edit-2" style="width: 14px;"></i>');
                    renderIcons();

                    // Bootstrap 5 modal
                    let modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    modal.show();
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(
                        '<i data-lucide="edit-2" style="width: 14px;"></i>');
                    showToast('Failed to load user data', 'danger');
                }
            });
        });
    </script>

    <!-- Update User AJAX -->
    <script>
        $(document).ready(function() {
            $('#updateUserBtn').on('click', function(e) {
                e.preventDefault();

                let btn = $(this);
                let userId = $('#editUserId').val();
                let name = $('#editUserName').val().trim();
                let email = $('#editUserEmail').val().trim();
                let role = $('#editUserRole').val();

                if (!name || !email) {
                    showToast('Please fill all required fields', 'danger');
                    return;
                }

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span><span>Saving...</span>');

                $.ajax({
                    url: '/user/update/' + userId,
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        _method: 'PUT',
                        name: name,
                        email: email,
                        role: role,
                        password: $('#editUserPassword').val()
                    },
                    success: function(response) {
                        let user = response.user;
                        let row = $('#userRow' + user.id);

                        // Update table row with icons
                        row.find('td:eq(0)').html(`
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i data-lucide="user" class="text-primary" style="width: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">${user.name}</h6>
                                    <small class="text-muted">Administrator</small>
                                </div>
                            </div>
                        `);
                        row.find('td:eq(1)').text(user.email);
                        let roleColorMap = { 'superadmin': 'danger', 'admin': 'warning', 'user': 'info' };
                        let roleColor = roleColorMap[user.role] || 'secondary';
                        row.find('td:eq(2)').html(`<span class="badge bg-${roleColor}">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span>`);

                        renderIcons();

                        // Close modal
                        bootstrap.Modal.getInstance(
                            document.getElementById('editUserModal')
                        ).hide();

                        btn.prop('disabled', false).html('<i data-lucide="save" style="width: 14px;"></i><span>Save Changes</span>');
                        showToast(response.message ?? 'User updated successfully!', 'success');
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('<i data-lucide="save" style="width: 14px;"></i><span>Save Changes</span>');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            showToast(errorMsg, 'danger');
                        } else {
                            showToast('Failed to update user', 'danger');
                        }
                    }
                });
            });
        });
    </script>

    <!-- Delete User AJAX -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteUserBtn', function() {
                let btn = $(this);
                let userId = btn.data('id');

                if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    return;
                }

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: '/user/delete/' + userId,
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        // Remove row with animation
                        $('#userRow' + userId).fadeOut(300, function() {
                            $(this).remove();
                            showToast(response.message, 'success');
                        });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(
                            '<i data-lucide="trash-2" style="width: 14px;"></i>');
                        showToast('Failed to delete user', 'danger');
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
