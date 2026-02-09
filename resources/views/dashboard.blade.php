@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h3 class="fw-bold mb-1">Dashboard Overview</h3>
        <p class="text-muted mb-0">Welcome back, Admin! Here's what's happening today.</p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary d-flex align-items-center gap-2">
            <i data-lucide="plus" style="width: 18px;"></i>
            <span>New Report</span>
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- Total Employees -->
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-title mb-1">Total Employees</p>
                        <h3 class="fw-bold mb-0">125</h3>
                    </div>
                    <div class="stat-icon bg-primary text-white">
                        <i data-lucide="users"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success fw-medium"><i data-lucide="arrow-up-right" class="me-1" style="width: 14px;"></i> 12%</span>
                    <span class="text-muted ms-2">from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Clients -->
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-title mb-1">Total Clients</p>
                        <h3 class="fw-bold mb-0">78</h3>
                    </div>
                    <div class="stat-icon bg-success text-white">
                        <i data-lucide="briefcase"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success fw-medium"><i data-lucide="arrow-up-right" class="me-1" style="width: 14px;"></i> 8.5%</span>
                    <span class="text-muted ms-2">from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Projects -->
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-title mb-1">Total Projects</p>
                        <h3 class="fw-bold mb-0">42</h3>
                    </div>
                    <div class="stat-icon bg-warning text-white">
                        <i data-lucide="kanban"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-danger fw-medium"><i data-lucide="arrow-down-right" class="me-1" style="width: 14px;"></i> 2.4%</span>
                    <span class="text-muted ms-2">from last week</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Quick Actions</h5>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary px-4 py-2">Manage Users</button>
                    <button class="btn btn-outline-primary px-4 py-2">Track Tasks</button>
                    <button class="btn btn-outline-secondary px-4 py-2">System Settings</button>
                    <button class="btn btn-outline-secondary px-4 py-2">View Logs</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize Lucide icons if dynamically added (optional but good practice)
    lucide.createIcons();
</script>
@endsection
