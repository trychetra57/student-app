@extends('layouts.app')

@section('title', 'Front Web - Footer Pages')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-file-alt me-2"></i> Footer Pages</h4>
                <p class="mb-0 text-white-50">Manage dynamic static content pages such as Privacy Policy, Terms of Service, FAQs, and Disclaimers.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" onclick="Swal.fire('Create Page', 'Mock static page editor creation form.', 'info')">
                <i class="fas fa-plus me-2"></i> Create Static Page
            </button>
        </div>
    </div>

    <!-- Static Pages List -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-dark">Static Pages Catalog</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4">Page Title</th>
                            <th>Relative URL (Slug)</th>
                            <th>SEO Description</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th class="pe-4 text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Page 1 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Privacy Policy</div>
                                <div class="text-muted small">Privacy safeguards and student data usage compliance framework.</div>
                            </td>
                            <td><code>/privacy-policy</code></td>
                            <td>LEARN Academy student and visitor privacy standards and cookies policies...</td>
                            <td>June 9, 2026</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Page', 'Opening Editor...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete static page?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Page 2 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Terms of Service</div>
                                <div class="text-muted small">Tuition agreements, code of conduct, and refund terms of the institution.</div>
                            </td>
                            <td><code>/terms-of-service</code></td>
                            <td>Terms of Service, guidelines, and policy requirements for LEARN Academy...</td>
                            <td>June 9, 2026</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Page', 'Opening Editor...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete static page?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Page 3 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Frequently Asked Questions (FAQ)</div>
                                <div class="text-muted small">Common queries regarding registration, levels, and placement diagnostic tests.</div>
                            </td>
                            <td><code>/faq</code></td>
                            <td>General questions about LEARN Academy English programs, costs, and terms...</td>
                            <td>May 12, 2026</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Page', 'Opening Editor...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete static page?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Page 4 -->
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">Rebranding Disclaimers</div>
                                <div class="text-muted small">Detailed transitions from our past branding.</div>
                            </td>
                            <td><code>/rebrand-disclaimer</code></td>
                            <td>Official disclaimers on academic certificate transition structures...</td>
                            <td>June 1, 2026</td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 me-1" onclick="Swal.fire('Edit Page', 'Opening Editor...', 'info')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-light border rounded-3 text-danger" onclick="Swal.fire('Delete', 'Delete static page?', 'warning')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
