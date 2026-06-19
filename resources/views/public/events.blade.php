@extends('layouts.public')

@section('title', 'Events & Campus News — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .events-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .events-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Event Card */
    .event-detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.04);
        border: 1px solid rgba(18, 88, 117, 0.05);
        overflow: hidden;
        margin-bottom: 40px;
        transition: var(--transition);
    }
    .event-detail-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 45px rgba(18, 88, 117, 0.08);
    }
    .event-img-wrapper {
        height: 250px;
        position: relative;
        overflow: hidden;
    }
    .event-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .event-detail-card:hover .event-img-wrapper img {
        transform: scale(1.05);
    }
    .event-date-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background-color: var(--accent);
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .event-info {
        padding: 30px;
    }
    .event-info h3 {
        font-weight: 800;
        color: var(--primary);
        font-size: 1.35rem;
        margin-bottom: 15px;
    }
    .event-info p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="events-hero">
    <div class="container">
        <h1>Events & Updates</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Stay up to date with speech competitions, writing webinars, open campus days, and academic updates at LEARN Academy.</p>
    </div>
</section>

<!-- Events List -->
<section class="section-padding">
    <div class="container" style="max-width: 900px;">
        
        @forelse($news as $article)
        @php
            $newsImg = $article->image_path ? (Str::startsWith($article->image_path, 'http') ? $article->image_path : asset($article->image_path)) : 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=400&auto=format&fit=crop';
        @endphp
        <div class="event-detail-card" id="article-{{ $article->id }}">
            <div class="row g-0">
                <div class="col-md-5 event-img-wrapper">
                    <img src="{{ $newsImg }}" alt="{{ $article->title }}">
                    <div class="event-date-badge">{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}</div>
                </div>
                <div class="col-md-7">
                    <div class="event-info">
                        <span class="badge bg-warning text-dark px-3 py-1 mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">{{ $article->category }}</span>
                        <h3>{{ $article->title }}</h3>
                        <p>{!! nl2br(e($article->content)) !!}</p>
                        <div class="d-flex align-items-center gap-2 mt-4 text-primary fw-bold">
                            <i class="fas fa-user-edit"></i> <span>Author: {{ $article->author }}</span>
                            <span class="mx-2">&bull;</span>
                            <i class="fas fa-eye"></i> <span>Views: {{ $article->views }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">No news or updates currently published.</div>
        @endforelse

    </div>
</section>
@endsection
