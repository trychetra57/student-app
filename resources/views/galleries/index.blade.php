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
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                <i class="fas fa-upload me-2"></i> Upload Images
            </button>
        </div>
    </div>

    <!-- Gallery Categories Grid -->
    <div class="row g-4 mb-4">
        @php
            $categories = ['Campus Classrooms', 'Computer Labs', 'Student Activities', 'Cafe & Lounge'];
        @endphp
        @foreach($categories as $cat)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden category-card" style="cursor: pointer;" onclick="filterCategory('{{ $cat }}')">
                <div style="height: 100px; background: linear-gradient(45deg, #125875, #01aa59); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-images fa-2x opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark mb-1">{{ $cat }}</h6>
                    <p class="text-muted small mb-0">{{ $galleries->where('category', $cat)->count() }} Photographs</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Active Media Grid list -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">All Media Files</h5>
                <select class="form-select form-select-sm rounded-3" style="width: 220px;" id="categorySelectFilter" onchange="filterCategory(this.value)">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3" id="galleryGrid">
                @forelse($galleries as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 gallery-item-card" data-category="{{ $item->category }}">
                    <div class="border rounded-3 p-2 h-100 position-relative">
                        <div class="ratio ratio-16x9 rounded overflow-hidden mb-2" style="background: #eee;">
                            @if(Str::startsWith($item->image_path, 'http'))
                                <img src="{{ $item->image_path }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="fw-bold small mb-1">{{ $item->title }}</div>
                        <div class="text-muted small mb-2"><i class="fas fa-tags me-1"></i> {{ $item->category }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ ucfirst($item->status ?: 'visible') }}</span>
                            <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 text-decoration-none" onclick="confirmDelete(event, this.form, 'Delete this gallery photo?')">
                                    <i class="fas fa-trash small"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">
                    No images uploaded in the gallery. Use the "Upload Images" button to add photos.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Upload Image Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="uploadImageModalLabel"><i class="fas fa-upload me-2"></i> Upload Photo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Photo Title / Label</label>
                        <input type="text" class="form-control rounded-3" name="title" required placeholder="e.g. Front office desk lobby">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Category</label>
                        <select class="form-select rounded-3" name="category" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Select Image File</label>
                        <input type="file" class="form-control rounded-3" name="image" required accept="image/*">
                        <div class="form-text small text-muted">Recommended 16:9 ratio, max 5MB.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-muted fw-bold">Visibility Status</label>
                        <select class="form-select rounded-3" name="status">
                            <option value="visible">Visible</option>
                            <option value="hidden">Hidden</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterCategory(category) {
        document.getElementById('categorySelectFilter').value = category === 'all' || !['Campus Classrooms', 'Computer Labs', 'Student Activities', 'Cafe & Lounge'].includes(category) ? 'all' : category;
        
        const items = document.querySelectorAll('.gallery-item-card');
        let visibleCount = 0;
        
        items.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            if (category === 'all' || itemCat === category) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection
