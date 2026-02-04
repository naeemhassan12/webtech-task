@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded shadow-sm bg-white">
            <div class="d-flex flex-column">
                {{-- <h5 class="fw-bold mb-2 text-primary">Active Task</h5> --}}
                @if ($activeTasks)
                    <div class="d-flex flex-row align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-truncate" style="max-width: 250px;">
                            {{ $activeTasks->task_title }}
                        </span>
                        <span class="text-muted">
                            {{ $activeTasks->client_name }}
                        </span>
                    </div>
                @else
                    <span class="text-muted">No active task available</span>
                @endif
                {{-- fetch the data from user table --}}
                <div class="d-flex flex-wrap align-items-center gap-1">
                    @forelse ($users as $user)
                        <span>{{ $user->name }}</span>
                        @if (!$loop->last)
                            <span class="text-muted">.</span>
                        @endif
                    @empty
                        <span class="text-muted">No users found</span>
                    @endforelse
                </div>
            </div>
            <div class="d-flex align-items-start ms-3">

                <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-3"
                    data-bs-toggle="modal" data-bs-target="#memberManageModal">
                    <i data-lucide="plus" style="width: 18px;"></i>
                    <span>Member Manage</span>
                </button>
            </div>

        </div>


    </div>


    
@endsection
