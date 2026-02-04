<div class="sidebar d-flex flex-column h-100">
    <div class="p-4">
        <h5 class="fw-bold mb-0 text-primary"><a href="{{ route('dashboard.create') }}">WebTechFusion</a></h5>
    </div>

    <div class="flex-grow-1 px-3">
        <ul class="nav flex-column gap-1">
            <li class="nav-item mt-2">
                <small class="text-uppercase text-muted fw-semibold ps-3 mb-2 d-block"
                    style="font-size: 0.7rem;">Management</small>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.create') }}"
                    class="nav-link {{ request()->routeIs('user.create') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('tasks.create') }}"
                    class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                    <i data-lucide="check-square"></i>
                    <span>Tasks</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <small class="text-uppercase text-muted fw-semibold ps-3 mb-2 d-block"
                    style="font-size: 0.7rem;">Pending Tasks</small>
            </li>
            @foreach ($pendingTasks as $task)
                <li class="nav-item">
                    <a href="{{ route('pending.index', $task->id) }}" class="nav-link d-flex align-items-center gap-1"
                        title="{{ $task->task_title }} - {{ $task->client_name }}">
                        <small
                            style="
                            color: chocolate;
                            max-width: 160px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            display: inline-block;">
                            {{ $task->task_title }} - {{ $task->client_name }}
                        </small>

                        <span class="badge bg-danger rounded-pill ms-auto">
                            {{ $pendingTasks->count() }}
                        </span>
                    </a>
                </li>
            @endforeach


            <li class="nav-item mt-2">
                <small class="text-uppercase text-muted fw-semibold ps-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Active Tasks
                </small>
            </li>

            @if ($activeTask->count() > 0)
                @foreach ($activeTask as $task)
                    <li class="nav-item">
                        <a href="{{ route('active-task.index', $task->id) }}"
                            class="nav-link d-flex align-items-center gap-1"
                            title="{{ $task->task_title }} - {{ $task->client_name }}">

                            <!-- Text (ellipsis applies here only) -->
                            <small
                                style="
                                    max-width: 160px;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    display: inline-block;
                                ">
                                {{ $task->task_title }} - {{ $task->client_name }}
                            </small>

                            <!-- Badge (always visible) -->
                            <span class="badge bg-danger rounded-pill ms-auto">
                                {{ $activeTask->count() }}
                            </span>
                        </a>
                    </li>
                @endforeach
            @endif

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
