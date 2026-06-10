@extends('layouts.app')

@section('title', 'Front Web - Gallery Management')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-images me-2"></i> Campus Gallery</h4>
                <p class="mb-0 text-white-50">Upload and manage photographs of classrooms, labs, events, and community activities displayed on the homepage.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" onclick="Swal.fire('Upload Photo', 'Mock image upload dialog.', 'info')">
                <i class="fas fa-upload me-2"></i> Upload Images
            </button>
        </div>
    </div>

    <!-- Gallery Categories Grid -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div style="height: 120px; background: linear-gradient(45deg, #125875, #ff7350); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-school fa-3x opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">Campus Classrooms</h6>
                    <p class="text-muted small mb-0">6 Active Photographs</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div style="height: 120px; background: linear-gradient(45deg, #0d3f54, #01aa59); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-laptop-code fa-3x opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">Computer Labs</h6>
                    <p class="text-muted small mb-0">4 Active Photographs</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div style="height: 120px; background: linear-gradient(45deg, #ff7350, #01aa59); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-award fa-3x opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">Student Activities</h6>
                    <p class="text-muted small mb-0">8 Active Photographs</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div style="height: 120px; background: #94a3b8; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-mug-hot fa-3x opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">Campus Cafe & Lounge</h6>
                    <p class="text-muted small mb-0">3 Active Photographs</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Media Grid list -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">All Media Files</h5>
                <select class="form-select form-select-sm rounded-3" style="width: 180px;">
                    <option>All Categories</option>
                    <option>Campus Classrooms</option>
                    <option>Computer Labs</option>
                    <option>Student Activities</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Image Item 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="border rounded-3 p-2 h-100 position-relative">
                        <div class="ratio ratio-16x9 rounded overflow-hidden mb-2" style="background: linear-gradient(135deg, #125875, #01aa59);">
                            <div class="d-flex align-items-center justify-content-center text-white small fw-bold">Classroom A</div>
                        </div>
                        <div class="fw-bold small mb-1">Modern interactive classroom</div>
                        <div class="text-muted small mb-2"><i class="fas fa-tags me-1"></i> Classrooms</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success rounded-pill">Visible</span>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Swal.fire('Delete', 'Delete item?', 'warning')"><i class="fas fa-trash small"></i> Delete</button>
                        </div>
                    </div>
                </div>
                <!-- Image Item 2 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="border rounded-3 p-2 h-100 position-relative">
                        <div class="ratio ratio-16x9 rounded overflow-hidden mb-2" style="background: linear-gradient(135deg, #ff7350, #125875);">
                            <div class="d-flex align-items-center justify-content-center text-white small fw-bold">Lab B</div>
                        </div>
                        <div class="fw-bold small mb-1">State-of-the-art computer labs</div>
                        <div class="text-muted small mb-2"><i class="fas fa-tags me-1"></i> Computer Labs</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success rounded-pill">Visible</span>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Swal.fire('Delete', 'Delete item?', 'warning')"><i class="fas fa-trash small"></i> Delete</button>
                        </div>
                    </div>
                </div>
                <!-- Image Item 3 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="border rounded-3 p-2 h-100 position-relative">
                        <div class="ratio ratio-16x9 rounded overflow-hidden mb-2" style="background: linear-gradient(135deg, #0d3f54, #01aa59);">
                            <div class="d-flex align-items-center justify-content-center text-white small fw-bold">Hall C</div>
                        </div>
                        <div class="fw-bold small mb-1">Spacious study lounge area</div>
                        <div class="text-muted small mb-2"><i class="fas fa-tags me-1"></i> Cafe & Lounge</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success rounded-pill">Visible</span>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Swal.fire('Delete', 'Delete item?', 'warning')"><i class="fas fa-trash small"></i> Delete</button>
                        </div>
                    </div>
                </div>
                <!-- Image Item 4 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="border rounded-3 p-2 h-100 position-relative">
                        <div class="ratio ratio-16x9 rounded overflow-hidden mb-2" style="background: linear-gradient(135deg, #ff7350, #01aa59);">
                            <div class="d-flex align-items-center justify-content-center text-white small fw-bold">Lobby D</div>
                        </div>
                        <div class="fw-bold small mb-1">Award celebration stage lobby</div>
                        <div class="text-muted small mb-2"><i class="fas fa-tags me-1"></i> Student Activities</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success rounded-pill">Visible</span>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Swal.fire('Delete', 'Delete item?', 'warning')"><i class="fas fa-trash small"></i> Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
