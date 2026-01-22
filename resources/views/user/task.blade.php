@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Page Header -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        Add New Task
    </button>

    <!-- Task Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Task Title</th>
                        <th>Client Name</th>
                        <th>Task Description</th>
                        <th>Status</th>
                        <th width="180">Action</th> <!-- Action Column -->
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Website Design</td>
                        <td>Ali Khan</td>
                        <td>Create homepage and dashboard UI</td>
                        <td><span class="badge bg-secondary">Pending</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>API Integration</td>
                        <td>Ahmed Raza</td>
                        <td>Integrate payment gateway API</td>
                        <td><span class="badge bg-primary">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Bug Fixing</td>
                        <td>Sara Ali</td>
                        <td>Resolve login authentication issues</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Testing Phase</td>
                        <td>Usman Shah</td>
                        <td>Complete system testing</td>
                        <td><span class="badge bg-info">Passed</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Project Delivery</td>
                        <td>Hassan Ali</td>
                        <td>Final deployment and delivery</td>
                        <td><span class="badge bg-success">Completed</span></td>
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

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" class="form-control" placeholder="Enter task title">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Client Name</label>
                        <input type="text" class="form-control" placeholder="Enter client name">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Task Description</label>
                    <textarea class="form-control" rows="3" placeholder="Enter task description"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="0">Pending</option>
                        <option value="1">Active</option>
                        <option value="2">Rejected</option>
                        <option value="3">Passed</option>
                        <option value="4">Completed</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" id="saveTaskBtn">Save Task</button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const addTaskModal = document.getElementById('addTaskModal');

    // Clear inputs when modal opens
    addTaskModal.addEventListener('show.bs.modal', function () {
        addTaskModal.querySelectorAll('input, textarea').forEach(el => el.value = '');
        addTaskModal.querySelector('select').value = '0';
    });

    // Save button (static)
    document.getElementById('saveTaskBtn').addEventListener('click', function () {
        alert('Task added successfully (Static Demo)');
        bootstrap.Modal.getInstance(addTaskModal).hide();
    });
</script>
@endsection
