@extends('layouts.app')



@section('content')
<div class="container mt-5">

    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-4">

        <!-- Total Employees -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Employees</h5>
                            <h3 class="card-text">125</h3>
                        </div>
                        <div>
                            <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Clients -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Clients</h5>
                            <h3 class="card-text">78</h3>
                        </div>
                        <div>
                            <i class="bi bi-briefcase-fill" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Projects</h5>
                            <h3 class="card-text">42</h3>
                        </div>
                        <div>
                            <i class="bi bi-kanban-fill" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')


@endsection
