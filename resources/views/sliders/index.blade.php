@extends('layouts.app')

@section('title', 'Front Web - Sliders Management')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-image me-2"></i> Sliders Management</h4>
                <p class="mb-0 text-white-50">Manage the hero slides on the public website homepage. Drag & drop to sort, or toggle active status.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" onclick="Swal.fire('Create Slide', 'This is a premium mock system. The create feature would open a popup or form here.', 'info')">
                <i class="fas fa-plus me-2"></i> Add New Slide
            </button>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Total Slides</div>
                        <div class="fs-3 fw-extrabold mt-1">4</div>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle p-3 fs-4">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Active Slides</div>
                        <div class="fs-3 fw-extrabold mt-1 text-success">3</div>
                    </div>
                    <div class="bg-success-subtle text-success rounded-circle p-3 fs-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Draft/Inactive</div>
                        <div class="fs-3 fw-extrabold mt-1 text-warning">1</div>
                    </div>
                    <div class="bg-warning-subtle text-warning rounded-circle p-3 fs-4">
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Click Through Rate</div>
                        <div class="fs-3 fw-extrabold mt-1 text-info">12.4%</div>
                    </div>
                    <div class="bg-info-subtle text-info rounded-circle p-3 fs-4">
                        <i class="fas fa-mouse-pointer"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sliders List -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">Live Homepage Slides</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm rounded-3" placeholder="Search slides..." style="width: 220px;">
                    <button class="btn btn-outline-secondary btn-sm rounded-3"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4" style="width: 80px;">Order</th>
                            <th>Preview</th>
                            <th>Slide Title</th>
                            <th>Target URL</th>
                            <th>Status</th>
                            <th>Clicks</th>
                            <th class="pe-4 text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Slide 1 -->
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary rounded-pill">1</span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 100px; height: 50px; background: linear-gradient(45deg, #125875, #ff7350); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: bold;">
                                    LEARN REBRAND
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">Welcome to LEARN Academy</div>
                                <div class="text-muted small">Special 15% discount for early registrants. Rebranding celebration!</div>
                            </td>
                            <td><code>/programs</code></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td><strong>245</strong></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Slide', 'Editing slide contents...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete Slide', 'Deleting slide...', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Slide 2 -->
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary rounded-pill">2</span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 100px; height: 50px; background: linear-gradient(45deg, #0d3f54, #01aa59); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: bold;">
                                    PLACEMENT TEST
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">Free Placement Diagnostic Test</div>
                                <div class="text-muted small">Test your English capability levels in real-time online.</div>
                            </td>
                            <td><code>/placement-test</code></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td><strong>182</strong></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Slide', 'Editing slide contents...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete Slide', 'Deleting slide...', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Slide 3 -->
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary rounded-pill">3</span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 100px; height: 50px; background: linear-gradient(45deg, #ff7350, #01aa59); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: bold;">
                                    CAMPUS TOUR
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">Premium Modern Campus Facilities</div>
                                <div class="text-muted small">Modern lecture halls, state-of-the-art computer labs and cafes.</div>
                            </td>
                            <td><code>/services</code></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td><strong>95</strong></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Slide', 'Editing slide contents...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete Slide', 'Deleting slide...', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Slide 4 -->
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary rounded-pill">4</span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 100px; height: 50px; background: #94a3b8; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: bold;">
                                    DRAFT SLIDE
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">Summer Registration Open</div>
                                <div class="text-muted small">Cohort registrations for July intake starting soon.</div>
                            </td>
                            <td><code>/tuition</code></td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Inactive</span></td>
                            <td><strong>0</strong></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Slide', 'Editing slide contents...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete Slide', 'Deleting slide...', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
