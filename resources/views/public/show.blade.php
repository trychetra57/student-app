@extends('layouts.public')

@section('title', $page->title . ' — LEARN Academy')

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }
    .page-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
    }
    .content-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 40px;
        margin-bottom: 50px;
    }
    .content-body h3 {
        color: var(--primary);
        font-weight: 800;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .content-body h5 {
        color: var(--primary-dark);
        font-weight: 700;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .content-body p {
        color: var(--text-dark);
        line-height: 1.8;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        @if($page->seo_description)
            <p class="lead text-white-50 max-width-700 mx-auto mb-0">{{ $page->seo_description }}</p>
        @endif
    </div>
</section>

<!-- Content Block -->
<section class="py-5 bg-light-custom">
    <div class="container" style="max-width: 800px;">
        <div class="content-card">
            <div class="content-body">
                {!! $page->content !!}
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted small">
                <span>Last Updated: {{ $page->updated_at ? $page->updated_at->format('F d, Y') : '-' }}</span>
                <a href="{{ route('home') }}" class="text-primary fw-bold text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to Homepage</a>
            </div>
        </div>
    </div>
</section>
@endsection
