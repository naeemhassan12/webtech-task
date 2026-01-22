<div class="sidebar p-3">
    <h4 class="text-center py-3">Admin Dashboard</h4>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard.create') }}" class="nav-link"><i class="fas fa-home me-2"></i>Home</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('user.create') }}" class="nav-link">
                <i class="fas fa-user me-2"></i>Users
            </a>

        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('user.show') }}" class="nav-link"><i class="fas fa-box me-2"></i>Task</a>
        </li>
        {{-- <li class="nav-item mb-2">
            <a href="#" class="nav-link"><i class="fas fa-chart-line me-2"></i>Analytics</a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link"><i class="fas fa-cog me-2"></i>Settings</a>
        </li> --}}
    </ul>
</div>
