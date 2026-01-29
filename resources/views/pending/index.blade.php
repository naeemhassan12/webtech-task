@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Pending Task</h2>
            
            <div class="d-flex flex-row gap-2 align-items-center">
                @foreach ($pendingTasks as $task)
                    <a href="{{ route('pending.index') }}" class="nav-link p-0">

                        <small>
                            {{ $task->client_name }}
                            @if (!$loop->last)
                                <span class="mx-1">•</span>
                            @endif
                        </small>

                    </a>
                @endforeach
            </div>

        </div>
        <div class="col-auto">
            <button class="btn btn-primary d-flex align-items-center gap-2">
                <i data-lucide="plus" style="width: 18px;"></i>
                <span>Add Members</span>
            </button>
        </div>
    </div>
@endsection
