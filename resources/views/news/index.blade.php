@extends('layouts.app')

@section('title', 'Front Web - News & Announcements')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-newspaper me-2"></i> News & Announcements</h4>
                <p class="mb-0 text-white-50">Publish articles, community highlights, and official statements on the front website portal.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" onclick="Swal.fire('Write Article', 'Mock option for writing articles.', 'info')">
                <i class="fas fa-pen me-2"></i> Create Article
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Published</div>
                        <div class="fs-3 fw-extrabold mt-1 text-success">18</div>
                    </div>
                    <div class="bg-success-subtle text-success rounded-circle p-3 fs-4">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Drafts</div>
                        <div class="fs-3 fw-extrabold mt-1 text-warning">4</div>
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
                        <div class="text-muted small fw-bold text-uppercase">Total Views</div>
                        <div class="fs-3 fw-extrabold mt-1 text-primary">5,420</div>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle p-3 fs-4">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Subscribers</div>
                        <div class="fs-3 fw-extrabold mt-1 text-info">1,204</div>
                    </div>
                    <div class="bg-info-subtle text-info rounded-circle p-3 fs-4">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">Articles & News</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm rounded-3" placeholder="Search articles..." style="width: 220px;">
                    <select class="form-select form-select-sm rounded-3">
                        <option value="all">All Statuses</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4">Article Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date Published</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th class="pe-4 text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Article 1 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Official Rebranding of LEARN Academy</div>
                                <div class="text-muted small">We are pleased to announce our transition to LEARN Academy with revamped classrooms...</div>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">Announcement</span></td>
                            <td>Dean Smith</td>
                            <td>June 9, 2026</td>
                            <td><strong>1,245</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Published</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Article', 'Editing article...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete article?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Article 2 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Outstanding Academic Achievement Scholarship Awards</div>
                                <div class="text-muted small">Highlights and photo coverage from the awards ceremony at the primary lobby.</div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill">Event</span></td>
                            <td>Admin PR</td>
                            <td>June 4, 2026</td>
                            <td><strong>842</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Published</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Article', 'Editing article...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete article?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Article 3 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Interactive ESL Speaking Sessions Start July Intake</div>
                                <div class="text-muted small">New syllabus structure incorporating peer teaching and group survival dialogs.</div>
                            </td>
                            <td><span class="badge bg-info-subtle text-info rounded-pill">Academic</span></td>
                            <td>Teacher Team</td>
                            <td>May 28, 2026</td>
                            <td><strong>412</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Published</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Article', 'Editing article...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete article?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Article 4 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">How to Succeed in Academic English Writing</div>
                                <div class="text-muted small">Practical strategies and citation tips from the Language Advising Service center.</div>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary rounded-pill">Tips</span></td>
                            <td>Advising Dept</td>
                            <td>May 15, 2026</td>
                            <td><strong>952</strong></td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Article', 'Editing article...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete article?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
