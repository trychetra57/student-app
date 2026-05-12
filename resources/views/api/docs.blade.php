@extends('layouts.app')

@section('title', 'API Documentation - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-code"></i> API Documentation</h1>
        <p class="text-muted">RESTful API endpoints for integrating with the Student Management System</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- API Endpoints -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Available Endpoints</h5>
                </div>
                <div class="card-body">
                    <!-- Students List -->
                    <div class="endpoint-item mb-4">
                        <h6 class="text-primary">GET /api/students</h6>
                        <p class="text-muted mb-2">Retrieve all students with basic information</p>
                        <div class="code-block">
                            <code>GET {{ url('/api/students') }}</code>
                        </div>
                        <small class="text-success">Authentication required</small>
                    </div>

                    <!-- Single Student -->
                    <div class="endpoint-item mb-4">
                        <h6 class="text-primary">GET /api/students/{id}</h6>
                        <p class="text-muted mb-2">Retrieve detailed information for a specific student</p>
                        <div class="code-block">
                            <code>GET {{ url('/api/students/1') }}</code>
                        </div>
                        <small class="text-success">Authentication required</small>
                    </div>

                    <!-- Dashboard Stats -->
                    <div class="endpoint-item">
                        <h6 class="text-primary">GET /api/dashboard/stats</h6>
                        <p class="text-muted mb-2">Get dashboard statistics and metrics</p>
                        <div class="code-block">
                            <code>GET {{ url('/api/dashboard/stats') }}</code>
                        </div>
                        <small class="text-success">Authentication required</small>
                    </div>
                </div>
            </div>

            <!-- Response Examples -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-code"></i> Response Examples</h5>
                </div>
                <div class="card-body">
                    <h6>Students List Response</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "+1234567890",
      "grade": "10th Grade",
      "status": "active",
      "documents_count": 2,
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}</code></pre>

                    <h6 class="mt-4">Dashboard Stats Response</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "success": true,
  "data": {
    "total_students": 150,
    "active_students": 140,
    "inactive_students": 5,
    "graduated_students": 5,
    "new_this_month": 12
  }
}</code></pre>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Test -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-flask"></i> Quick Test</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Test the API endpoints directly in your browser:</p>
                    <div class="d-grid gap-2">
                        <a href="{{ url('/api/dashboard/stats') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> Test Dashboard Stats
                        </a>
                        <a href="{{ url('/api/students') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> Test Students List
                        </a>
                    </div>
                    <div class="alert alert-info mt-3">
                        <small><i class="fas fa-info-circle"></i> You must be logged in to access these endpoints.</small>
                    </div>
                </div>
            </div>

            <!-- Authentication -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-lock"></i> Authentication</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">All API endpoints require authentication.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Session-based authentication</li>
                        <li><i class="fas fa-check text-success"></i> CSRF protection</li>
                        <li><i class="fas fa-check text-success"></i> JSON responses</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.endpoint-item {
    border-left: 4px solid #007bff;
    padding-left: 15px;
}

.code-block {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    margin: 0.5rem 0;
}

pre code {
    font-size: 0.75rem;
    line-height: 1.4;
}
</style>
@endsection