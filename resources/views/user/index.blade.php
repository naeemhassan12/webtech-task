@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>User Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add New User
        </button>
    </div>

    <!-- Static Users Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ali Khan</td>
                        <td>ali@gmail.com</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>Ahmed Raza</td>
                        <td>ahmed@gmail.com</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>Sara Ali</td>
                        <td>sara@gmail.com</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Add New User Modal (Static) -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter full name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" placeholder="Enter username">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Enter email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Enter password">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success">Save User</button>
            </div>

        </div>
    </div>
</div>
@endsection



@section('scripts')
<script>
    // When modal opens, clear all input fields
    const addUserModal = document.getElementById('addUserModal');

    addUserModal.addEventListener('show.bs.modal', function () {
        const inputs = addUserModal.querySelectorAll('input');
        inputs.forEach(input => input.value = '');
    });

    // Handle Save User button click
    document.querySelector('.btn-success').addEventListener('click', function () {
        alert('User saved successfully (Static Demo)');

        // Close modal
        const modal = bootstrap.Modal.getInstance(addUserModal);
        modal.hide();
    });
</script>

@endsection
