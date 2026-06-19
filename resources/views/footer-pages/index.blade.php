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
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addPageModal">
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
                        @forelse($pages as $page)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $page->title }}</div>
                                <div class="text-muted small">{{ Str::limit(strip_tags($page->content), 70) }}</div>
                            </td>
                            <td><code>/pages/{{ $page->slug }}</code></td>
                            <td>{{ Str::limit($page->seo_description, 60) ?: '-' }}</td>
                            <td>{{ $page->updated_at ? $page->updated_at->format('M d, Y') : '-' }}</td>
                            <td>
                                <form action="{{ route('admin.footer-pages.toggle', $page->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                        @if($page->status === 'active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 edit-page-btn me-1" 
                                    data-id="{{ $page->id }}" 
                                    data-title="{{ $page->title }}" 
                                    data-slug="{{ $page->slug }}" 
                                    data-seo="{{ $page->seo_description }}" 
                                    data-status="{{ $page->status }}"
                                    data-content="{{ $page->content }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.footer-pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border rounded-3 text-danger" onclick="confirmDelete(event, this.form, 'Delete static page? This will render its link invalid.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No footer pages exist. Create a static page.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="addPageModalLabel"><i class="fas fa-plus me-2"></i> Create Static Page</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.footer-pages.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Page Title</label>
                            <input type="text" class="form-control rounded-3" name="title" required placeholder="e.g. Privacy Policy">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Slug (Optional)</label>
                            <input type="text" class="form-control rounded-3" name="slug" placeholder="e.g. privacy-policy">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">SEO Description (Meta Tag)</label>
                            <input type="text" class="form-control rounded-3" name="seo_description" placeholder="Short summary for Google search results...">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Status</label>
                            <select class="form-select rounded-3" name="status" required>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Page Content (HTML Allowed)</label>
                            <textarea class="form-control rounded-3" name="content" rows="10" required placeholder="<h3>Heading</h3><p>Page text content here...</p>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Save Page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Page Modal -->
<div class="modal fade" id="editPageModal" tabindex="-1" aria-labelledby="editPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="editPageModalLabel"><i class="fas fa-edit me-2"></i> Edit Static Page</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPageForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Page Title</label>
                            <input type="text" class="form-control rounded-3" id="edit_title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Slug</label>
                            <input type="text" class="form-control rounded-3" id="edit_slug" name="slug">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">SEO Description</label>
                            <input type="text" class="form-control rounded-3" id="edit_seo" name="seo_description">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Status</label>
                            <select class="form-select rounded-3" id="edit_status" name="status" required>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Page Content (HTML Allowed)</label>
                            <textarea class="form-control rounded-3" id="edit_content" name="content" rows="10" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Update Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.edit-page-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const slug = this.getAttribute('data-slug');
            const seo = this.getAttribute('data-seo');
            const status = this.getAttribute('data-status');
            const content = this.getAttribute('data-content');

            document.getElementById('edit_title').value = title;
            document.getElementById('edit_slug').value = slug;
            document.getElementById('edit_seo').value = seo;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_content').value = content;

            // Set form action
            document.getElementById('editPageForm').action = `{{ url('admin/footer-pages') }}/${id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editPageModal'));
            modal.show();
        });
    });
</script>
@endsection
