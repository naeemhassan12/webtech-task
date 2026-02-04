@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Task Assignments</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Title</th>
                <th>User Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskUsers as $tu)
                <tr>
                    <td>{{ $tu->id }}</td>
                    <td>{{ $tu->task->task_title ?? 'N/A' }}</td>
                    <td>{{ $tu->user->name ?? 'N/A' }}</td>
                    <td>{{ $tu->created_at }}</td>
                    <td>{{ $tu->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
