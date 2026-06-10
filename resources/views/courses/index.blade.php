@extends('layouts.app')

@section('title', 'Front Web - Courses Management')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-book-open me-2"></i> Courses & Curriculum</h4>
                <p class="mb-0 text-white-50">Manage the course catalog offered by LEARN Academy, including fees, schedule details, and levels.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" onclick="Swal.fire('Add Course', 'Mock function for course creation.', 'info')">
                <i class="fas fa-plus me-2"></i> Add New Course
            </button>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">Course Catalog</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm rounded-3" placeholder="Search catalog..." style="width: 220px;">
                    <select class="form-select form-select-sm rounded-3">
                        <option value="all">All Levels</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4">Course Name</th>
                            <th>Code</th>
                            <th>Category / Level</th>
                            <th>Duration</th>
                            <th>Tuition Fee</th>
                            <th>Status</th>
                            <th class="pe-4 text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Course 1 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">University Survival English</div>
                                <div class="text-muted small">Intensive prep for lecture comprehension and campus communication.</div>
                            </td>
                            <td><code>USE-101</code></td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">Academic English</span></td>
                            <td>12 Weeks</td>
                            <td><strong class="text-dark">$180.00</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Course', 'Editing course USE-101...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete course?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Course 2 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">NextGen English</div>
                                <div class="text-muted small">Foundational writing and structure for modern communication.</div>
                            </td>
                            <td><code>NGE-202</code></td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">General English</span></td>
                            <td>10 Weeks</td>
                            <td><strong class="text-dark">$150.00</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Course', 'Editing course NGE-202...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete course?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Course 3 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">English Anytime Anywhere</div>
                                <div class="text-muted small">Flex schedule vocabulary and conversational structures for working professionals.</div>
                            </td>
                            <td><code>EAA-303</code></td>
                            <td><span class="badge bg-info-subtle text-info rounded-pill">Vocational</span></td>
                            <td>15 Weeks</td>
                            <td><strong class="text-dark">$220.00</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Course', 'Editing course EAA-303...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete course?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Course 4 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">English for Academic Writing</div>
                                <div class="text-muted small">IELTS/TOEFL standard essays, paragraphs, and research writing skills.</div>
                            </td>
                            <td><code>EAW-404</code></td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill">Advanced</span></td>
                            <td>12 Weeks</td>
                            <td><strong class="text-dark">$240.00</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Course', 'Editing course EAW-404...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete course?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Course 5 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">English for Business</div>
                                <div class="text-muted small">Presentation delivery, meeting language, and official emails writing templates.</div>
                            </td>
                            <td><code>EFB-505</code></td>
                            <td><span class="badge bg-warning-subtle text-warning rounded-pill">Business</span></td>
                            <td>8 Weeks</td>
                            <td><strong class="text-dark">$195.00</strong></td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Course', 'Editing course EFB-505...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete course?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
