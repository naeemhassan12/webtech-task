<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebTech | Modern Business Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .hero-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        }
        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        .feature-card {
            border: none;
            border-radius: 16px;
            padding: 30px;
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            height: 100%;
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="#">WebTech</a>
            <div class="ms-auto">
                <a href="{{ route('dashboard.create') }}" class="btn btn-outline-primary fw-semibold px-4 rounded-3 me-2">Login</a>
                <a href="{{ route('dashboard.create') }}" class="btn btn-primary fw-semibold rounded-3">Get Started</a>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-4">Streamline Your <span class="text-primary">Workflow</span></h1>
            <p class="lead text-muted mb-5 max-w-2xl mx-auto">WebTech provides the ultimate dashboard experience for managing employees, clients, and projects with precision and ease.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('dashboard.create') }}" class="btn btn-primary btn-lg px-5">Go to Dashboard</a>
                <a href="{{ route('user.show') }}" class="btn btn-light btn-lg px-5 border shadow-sm">View Tasks</a>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i data-lucide="layout-dashboard"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Modern Analytics</h4>
                        <p class="text-muted">Get real-time insights with our professional statistic cards and data visualization tools.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i data-lucide="users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">User Management</h4>
                        <p class="text-muted">Effortlessly manage your team and clients with our streamlined and intuitive user system.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i data-lucide="check-square"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Task Tracking</h4>
                        <p class="text-muted">Keep projects on schedule with advanced task management and status monitoring.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-white border-top">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} WebTech. All rights reserved.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
