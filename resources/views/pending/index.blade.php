@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded shadow-sm bg-white">
            <div class="d-flex flex-column">
                @if ($pendingtasks)
                    <div class="d-flex flex-row align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-truncate" style="max-width: 250px;">
                            {{ $pendingtasks->task_title }}
                        </span>
                        <span class="text-muted">
                            {{ $pendingtasks->client_name }}
                        </span>
                    </div>
                @else
                    <span class="text-muted">No pending task available</span>
                @endif
                {{-- fetch data from user table --}}
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
    {{-- model  --}}
    {{-- <div class="modal fade" id="memberManageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Member Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Member Name</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                    @php
                                        $isAdded = in_array($user->id, $taskMembers ?? []);
                                    @endphp

                                    <tr id="row-{{ $user->id }}">
                                        <td class="fw-semibold">
                                            {{ $user->name }}
                                        </td>

                                        <td class="text-end">
                                            <button id="btn-{{ $user->id }}"
                                                class="btn btn-sm {{ $isAdded ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                onclick="{{ $isAdded ? 'removeMember' : 'addMember' }}({{ $user->id }}, '{{ $user->name }}')">
                                                {{ $isAdded ? 'Remove' : 'Add' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function addMember(userId, userName) {
            const btn = document.getElementById('btn-' + userId);
            // switch button
            btn.className = 'btn btn-sm btn-outline-danger';
            btn.innerText = 'Remove';
            btn.setAttribute('onclick', `removeMember(${userId}, '${userName}')`);
            // popup
            showToast(`${userName} added successfully`);
        }

        function removeMember(userId, userName) {
            const btn = document.getElementById('btn-' + userId);
            // switch button
            btn.className = 'btn btn-sm btn-outline-success';
            btn.innerText = 'Add';
            btn.setAttribute('onclick', `addMember(${userId}, '${userName}')`);
            // popup
            showToast(`${userName} removed successfully`, 'danger');
        }
        // simple toast popup
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
            toast.style.zIndex = 1055;
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }
    </script> --}}
    <div class="modal fade" id="memberManageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Member Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Member Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $isAdded = in_array($user->id, $taskMembers ?? []);
                                @endphp

                                <tr>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm {{ $isAdded ? 'btn-outline-danger' : 'btn-outline-success' }} member-btn"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-added="{{ $isAdded ? '1' : '0' }}">
                                            {{ $isAdded ? 'Remove' : 'Add' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('member-btn')) return;

    const btn = e.target;
    const userId = btn.dataset.userId;
    const userName = btn.dataset.userName;
    const isAdded = btn.dataset.added === '1';

    if (isAdded) {
        // REMOVE
        btn.className = 'btn btn-sm btn-outline-success member-btn';
        btn.innerText = 'Add';
        btn.dataset.added = '0';
        showToast(`${userName} removed successfully`, 'danger');
    } else {
        // ADD
        btn.className = 'btn btn-sm btn-outline-danger member-btn';
        btn.innerText = 'Remove';
        btn.dataset.added = '1';
        showToast(`${userName} added successfully`);
    }
});

// Toast
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
    toast.style.zIndex = 1055;
    toast.innerText = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 2000);
}
</script>

@endsection
