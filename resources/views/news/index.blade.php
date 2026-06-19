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
            <button class="btn btn-light text-primary fw-bold px-4 rounded-3 mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addNewsModal">
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
                        <div class="fs-3 fw-extrabold mt-1 text-success">{{ $news->where('status', 'published')->count() }}</div>
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
                        <div class="fs-3 fw-extrabold mt-1 text-warning">{{ $news->where('status', 'draft')->count() }}</div>
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
                        <div class="fs-3 fw-extrabold mt-1 text-primary">{{ $news->sum('views') }}</div>
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
                        <div class="text-muted small fw-bold text-uppercase">Total Articles</div>
                        <div class="fs-3 fw-extrabold mt-1 text-info">{{ $news->count() }}</div>
                    </div>
                    <div class="bg-info-subtle text-info rounded-circle p-3 fs-4">
                        <i class="fas fa-newspaper"></i>
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
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-4">Preview</th>
                            <th>Article Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date Published</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th class="pe-4 text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                        <tr>
                            <td class="ps-4">
                                <div class="rounded-3 overflow-hidden shadow-sm" style="width: 60px; height: 40px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                    @if($article->image_path)
                                        @if(Str::startsWith($article->image_path, 'http'))
                                            <img src="{{ $article->image_path }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset($article->image_path) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    @else
                                        <span class="small text-muted text-uppercase" style="font-size: 0.6rem; font-weight: bold;">NO PIC</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $article->title }}</div>
                                <div class="text-muted small">{{ Str::limit(strip_tags($article->content), 80) }}</div>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">{{ $article->category }}</span></td>
                            <td>{{ $article->author }}</td>
                            <td>{{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}</td>
                            <td><strong>{{ $article->views }}</strong></td>
                            <td>
                                <form action="{{ route('admin.news.toggle', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                        @if($article->status === 'published')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Published</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Draft</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border rounded-3 edit-news-btn me-1" 
                                    data-id="{{ $article->id }}" 
                                    data-title="{{ $article->title }}" 
                                    data-category="{{ $article->category }}" 
                                    data-author="{{ $article->author }}" 
                                    data-status="{{ $article->status }}" 
                                    data-pub="{{ $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '' }}"
                                    data-content="{{ $article->content }}"
                                    data-image="{{ $article->image_path }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border rounded-3 text-danger" onclick="confirmDelete(event, this.form, 'Are you sure you want to delete this article?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No news articles in the database. Create your first article.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="addNewsModalLabel"><i class="fas fa-pen me-2"></i> Create News Article</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Article Title</label>
                            <input type="text" class="form-control rounded-3" name="title" required placeholder="e.g. Official Rebranding of LEARN Academy">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Category</label>
                            <input type="text" class="form-control rounded-3" name="category" required placeholder="e.g. Announcement, Event">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Author</label>
                            <input type="text" class="form-control rounded-3" name="author" required value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Publication Status</label>
                            <select class="form-select rounded-3" name="status" required>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Cover Image</label>
                            <input type="file" class="form-control rounded-3" name="image" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Published Date/Time (Optional)</label>
                            <input type="datetime-local" class="form-control rounded-3" name="published_at">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Content</label>
                            <textarea class="form-control rounded-3" name="content" rows="6" required placeholder="Type the article content here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Save Article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="editNewsModalLabel"><i class="fas fa-edit me-2"></i> Edit Article</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editNewsForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-uppercase small text-muted fw-bold">Article Title</label>
                            <input type="text" class="form-control rounded-3" id="edit_title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-uppercase small text-muted fw-bold">Category</label>
                            <input type="text" class="form-control rounded-3" id="edit_category" name="category" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Author</label>
                            <input type="text" class="form-control rounded-3" id="edit_author" name="author" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Publication Status</label>
                            <select class="form-select rounded-3" id="edit_status" name="status" required>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Replace Cover Image</label>
                            <input type="file" class="form-control rounded-3" name="image" accept="image/*">
                            <div class="mt-2">
                                <img id="edit_image_preview" src="" alt="Current image preview" class="img-fluid rounded border shadow-sm" style="max-height: 80px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase small text-muted fw-bold">Published Date/Time</label>
                            <input type="datetime-local" class="form-control rounded-3" id="edit_published_at" name="published_at">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase small text-muted fw-bold">Content</label>
                            <textarea class="form-control rounded-3" id="edit_content" name="content" rows="6" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3"><i class="fas fa-save me-1"></i> Update Article</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.edit-news-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const category = this.getAttribute('data-category');
            const author = this.getAttribute('data-author');
            const status = this.getAttribute('data-status');
            const pub = this.getAttribute('data-pub');
            const content = this.getAttribute('data-content');
            const img = this.getAttribute('data-image');

            document.getElementById('edit_title').value = title;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_author').value = author;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_published_at').value = pub;
            document.getElementById('edit_content').value = content;

            const preview = document.getElementById('edit_image_preview');
            if(img) {
                preview.src = img.startsWith('http') ? img : '{{ asset("") }}' + img.replace(/^\//, '');
                preview.style.display = 'inline-block';
            } else {
                preview.style.display = 'none';
            }

            // Set form action
            document.getElementById('editNewsForm').action = `{{ url('admin/news') }}/${id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
            modal.show();
        });
    });
</script>
@endsection
