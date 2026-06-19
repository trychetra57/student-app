@extends('layouts.app')

@section('title', 'Front Web - Sliders Management')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-image me-2"></i> Sliders Management</h4>
                <p class="mb-0 text-white-50">Manage the hero slides on the public website homepage. Toggle active status or delete slides.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addSlideModal">
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
                        <div class="fs-3 fw-extrabold mt-1">{{ $sliders->count() }}</div>
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
                        <div class="fs-3 fw-extrabold mt-1 text-success">{{ $sliders->where('is_active', true)->count() }}</div>
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
                        <div class="fs-3 fw-extrabold mt-1 text-warning">{{ $sliders->where('is_active', false)->count() }}</div>
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
                        <div class="text-muted small fw-bold text-uppercase">Total Clicks</div>
                        <div class="fs-3 fw-extrabold mt-1 text-info">{{ $sliders->sum('clicks') }}</div>
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
                    <tbody id="slidersTableBody">
                        @forelse($sliders as $slider)
                        <tr data-id="{{ $slider->id }}">
                            <td class="ps-4">
                                <span class="badge bg-secondary rounded-pill">{{ $slider->order_index }}</span>
                            </td>
                            <td>
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 100px; height: 50px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                    @if(Str::startsWith($slider->image_path, 'http'))
                                        <img src="{{ $slider->image_path }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset($slider->image_path) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $slider->title }}</div>
                                <div class="text-muted small">{{ Str::limit($slider->subtitle, 70) }}</div>
                            </td>
                            <td><code>{{ $slider->target_url ?: '/' }}</code></td>
                            <td>
                                <form action="{{ route('admin.sliders.toggle', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                        @if($slider->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Inactive</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td><strong>{{ $slider->clicks }}</strong></td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 edit-slide-btn me-1" 
                                    data-id="{{ $slider->id }}" 
                                    data-title="{{ $slider->title }}" 
                                    data-subtitle="{{ $slider->subtitle }}" 
                                    data-url="{{ $slider->target_url }}" 
                                    data-active="{{ $slider->is_active ? '1' : '0' }}"
                                    data-image="{{ $slider->image_path }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline delete-slider-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border rounded-3 text-danger" onclick="confirmDelete(event, this.form, 'Are you sure you want to delete this slide?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No sliders configured. Click "Add New Slide" to begin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Slide Modal -->
<div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="addSlideModalLabel"><i class="fas fa-plus me-2"></i> Add New Slide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Slide Title</label>
                        <input type="text" class="form-control rounded-3" name="title" required placeholder="e.g. Welcome to LEARN Academy">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Subtitle / Description</label>
                        <textarea class="form-control rounded-3" name="subtitle" rows="3" placeholder="e.g. Special offer details..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Target URL</label>
                        <input type="text" class="form-control rounded-3" name="target_url" placeholder="e.g. /programs">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Slide Image</label>
                        <input type="file" class="form-control rounded-3" name="image" required accept="image/*">
                        <div class="form-text small text-muted">Recommended aspect ratio: 16:9, max size: 5MB.</div>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="add_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label fw-bold text-muted small text-uppercase" for="add_is_active">Make Active Immediately</label>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Save Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slide Modal -->
<div class="modal fade" id="editSlideModal" tabindex="-1" aria-labelledby="editSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="editSlideModalLabel"><i class="fas fa-edit me-2"></i> Edit Slide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSlideForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Slide Title</label>
                        <input type="text" class="form-control rounded-3" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Subtitle / Description</label>
                        <textarea class="form-control rounded-3" id="edit_subtitle" name="subtitle" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Target URL</label>
                        <input type="text" class="form-control rounded-3" id="edit_target_url" name="target_url">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Replace Slide Image</label>
                        <input type="file" class="form-control rounded-3" name="image" accept="image/*">
                        <div class="form-text small text-muted">Leave empty to keep current image. Recommended 16:9, max 5MB.</div>
                        <div class="mt-2 text-center">
                            <img id="edit_image_preview" src="" alt="Current slide image" class="img-fluid rounded border shadow-sm" style="max-height: 120px;">
                        </div>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label fw-bold text-muted small text-uppercase" for="edit_is_active">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Update Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.edit-slide-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const subtitle = this.getAttribute('data-subtitle');
            const url = this.getAttribute('data-url');
            const active = this.getAttribute('data-active') === '1';
            const img = this.getAttribute('data-image');

            document.getElementById('edit_title').value = title;
            document.getElementById('edit_subtitle').value = subtitle;
            document.getElementById('edit_target_url').value = url;
            document.getElementById('edit_is_active').checked = active;

            const preview = document.getElementById('edit_image_preview');
            if(img) {
                preview.src = img.startsWith('http') ? img : '{{ asset("") }}' + img.replace(/^\//, '');
                preview.style.display = 'inline-block';
            } else {
                preview.style.display = 'none';
            }

            // Set form action
            document.getElementById('editSlideForm').action = `{{ url('admin/sliders') }}/${id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editSlideModal'));
            modal.show();
        });
    });
</script>
@endsection
