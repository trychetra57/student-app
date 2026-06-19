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
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <i class="fas fa-plus me-2"></i> Add New Course
            </button>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">Course Catalog</h5>
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
                        @forelse($courses as $course)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $course->name }}</div>
                                <div class="text-muted small">{{ Str::limit($course->description, 100) }}</div>
                            </td>
                            <td><code>{{ $course->code }}</code></td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">{{ $course->category }}</span></td>
                            <td>{{ $course->duration }}</td>
                            <td><strong class="text-dark">${{ number_format($course->tuition_fee, 2) }}</strong></td>
                            <td>
                                <form action="{{ route('admin.courses.toggle', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                        @if($course->status === 'active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 edit-course-btn me-1" 
                                    data-id="{{ $course->id }}" 
                                    data-name="{{ $course->name }}" 
                                    data-code="{{ $course->code }}" 
                                    data-category="{{ $course->category }}" 
                                    data-duration="{{ $course->duration }}" 
                                    data-fee="{{ $course->tuition_fee }}" 
                                    data-status="{{ $course->status }}"
                                    data-desc="{{ $course->description }}"
                                    data-outcomes="{{ $course->outcomes }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border rounded-3 text-danger" onclick="confirmDelete(event, this.form, 'Delete course? This will remove it from catalog.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No courses in the database. Add a new course.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="addCourseModalLabel"><i class="fas fa-plus me-2"></i> Add New Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Course Name</label>
                            <input type="text" class="form-control rounded-3" name="name" required placeholder="e.g. NextGen English">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Course Code</label>
                            <input type="text" class="form-control rounded-3" name="code" required placeholder="e.g. NGE-202">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Category / Level</label>
                            <input type="text" class="form-control rounded-3" name="category" required placeholder="e.g. General English">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase small text-muted fw-bold">Duration</label>
                            <input type="text" class="form-control rounded-3" name="duration" required placeholder="e.g. 12 Weeks">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase small text-muted fw-bold">Tuition Fee ($)</label>
                            <input type="number" step="0.01" class="form-control rounded-3" name="tuition_fee" required placeholder="0.00">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Status</label>
                            <select class="form-select rounded-3" name="status" required>
                                <option value="active">Active (Visible on public site)</option>
                                <option value="draft">Draft (Hidden)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Description</label>
                            <textarea class="form-control rounded-3" name="description" rows="3" placeholder="Brief summary of course content..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Key Outcomes (One per line)</label>
                            <textarea class="form-control rounded-3" name="outcomes" rows="4" placeholder="Outcome 1&#10;Outcome 2&#10;Outcome 3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="editCourseModalLabel"><i class="fas fa-edit me-2"></i> Edit Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCourseForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Course Name</label>
                            <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Course Code</label>
                            <input type="text" class="form-control rounded-3" id="edit_code" name="code" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Category / Level</label>
                            <input type="text" class="form-control rounded-3" id="edit_category" name="category" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase small text-muted fw-bold">Duration</label>
                            <input type="text" class="form-control rounded-3" id="edit_duration" name="duration" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase small text-muted fw-bold">Tuition Fee ($)</label>
                            <input type="number" step="0.01" class="form-control rounded-3" id="edit_fee" name="tuition_fee" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Status</label>
                            <select class="form-select rounded-3" id="edit_status" name="status" required>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Description</label>
                            <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Key Outcomes (One per line)</label>
                            <textarea class="form-control rounded-3" id="edit_outcomes" name="outcomes" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.edit-course-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const code = this.getAttribute('data-code');
            const category = this.getAttribute('data-category');
            const duration = this.getAttribute('data-duration');
            const fee = this.getAttribute('data-fee');
            const status = this.getAttribute('data-status');
            const desc = this.getAttribute('data-desc');
            const outcomes = this.getAttribute('data-outcomes');

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_duration').value = duration;
            document.getElementById('edit_fee').value = fee;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_description').value = desc;
            document.getElementById('edit_outcomes').value = outcomes;
            
            // Set form action
            document.getElementById('editCourseForm').action = `{{ url('admin/courses') }}/${id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editCourseModal'));
            modal.show();
        });
    });
</script>
@endsection
