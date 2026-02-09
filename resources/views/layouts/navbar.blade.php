<nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top py-2">
    <div class="container-fluid">
        <!-- Sidebar Toggle for Mobile -->
        <button class="btn btn-link link-dark border-0 p-0 me-3 d-md-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i data-lucide="menu"></i>
        </button>

        <!-- Brand (Mobile only) -->
        <a class="navbar-brand fw-bold text-primary d-md-none" href="#">WebTech</a>

        <!-- Search Bar (Desktop) -->
        <div class="d-none d-md-flex align-items-center flex-grow-1 max-w-md ms-3">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 border-light border-0 px-2"><i data-lucide="search" style="width: 18px;" class="text-muted"></i></span>
                <input type="text" class="form-control bg-light border-start-0 border-light border-0 shadow-none" placeholder="Search anything..." style="font-size: 0.9rem;">
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <a class="nav-link d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 34px; height: 34px; font-size: 0.85rem; font-weight: 600;">
                        AD
                    </div>
                    <span class="d-none d-lg-inline fw-semibold text-dark me-1" style="font-size: 0.9rem;">Admin User</span>
                    <i data-lucide="chevron-down" class="text-muted" style="width: 14px;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" aria-labelledby="profileDropdown">
                    <li class="px-3 py-2 border-bottom mb-1">
                        <p class="mb-0 fw-bold" style="font-size: 0.85rem;">Admin User</p>
                        <small class="text-muted">admin@webtech.com</small>
                    </li>
                    <li><a class="dropdown-item py-2 d-flex align-items-center" href="#"><i data-lucide="user" class="me-2 text-muted" style="width: 16px;"></i>Profile</a></li>
                    <li><a class="dropdown-item py-2 d-flex align-items-center" href="#"><i data-lucide="settings" class="me-2 text-muted" style="width: 16px;"></i>Settings</a></li>
                    <li><hr class="dropdown-divider opacity-50"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger border-0 bg-transparent w-100">
                                <i data-lucide="log-out" class="me-2" style="width: 16px;"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
