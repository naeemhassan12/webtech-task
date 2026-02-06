@foreach ($tasks as $task)
    <li class="nav-item">
        <a href="{{ route($type === 'pending' ? 'pending.index' : 'active-task.index', $task->id) }}" class="nav-link d-flex align-items-center gap-1"
            title="{{ $task->task_title }} - {{ $task->client_name }}">
            <small
                style="
                {{ $type === 'pending' ? 'color: chocolate;' : '' }}
                max-width: 160px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: inline-block;">
                {{ $task->task_title }} - {{ $task->client_name }}
            </small>

            <span class="badge bg-danger rounded-pill ms-auto">
                {{ $tasks->count() }}
            </span>
        </a>
    </li>
@endforeach
