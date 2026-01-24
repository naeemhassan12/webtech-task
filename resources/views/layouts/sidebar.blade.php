<div class="sidebar d-flex flex-column h-100">
    <div class="p-4">
        <h5 class="fw-bold mb-0 text-primary">WebTech</h5>
        <small class="text-muted">Admin Panel</small>
    </div>
    
    <div class="flex-grow-1 px-3">
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('dashboard.create') }}" class="nav-link {{ request()->routeIs('dashboard.create') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <small class="text-uppercase text-muted fw-semibold ps-3 mb-2 d-block" style="font-size: 0.7rem;">Management</small>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link {{ request()->routeIs('user.create') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.show') }}" class="nav-link {{ request()->routeIs('user.show') ? 'active' : '' }}">
                    <i data-lucide="check-square"></i>
                    <span>Tasks</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="p-4 border-top">
        <ul class="nav flex-column px-3 gap-1">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i data-lucide="settings"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
