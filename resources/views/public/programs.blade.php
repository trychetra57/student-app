@extends('layouts.public')

@section('title', 'Academic Programs — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .prog-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .prog-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Program Section Styling */
    .program-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid rgba(18, 88, 117, 0.05);
        overflow: hidden;
        margin-bottom: 50px;
        transition: var(--transition);
    }
    .program-card:hover {
        box-shadow: 0 15px 50px rgba(18, 88, 117, 0.08);
        transform: translateY(-4px);
    }
    .program-header-banner {
        background-color: var(--primary);
        color: white;
        padding: 35px 40px;
        position: relative;
    }
    .program-header-banner h2 {
        font-weight: 800;
        margin-bottom: 5px;
        font-size: 1.8rem;
    }
    .program-badge {
        position: absolute;
        top: 35px;
        right: 40px;
        background-color: var(--accent);
        color: white;
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .program-body {
        padding: 40px;
    }
    .program-meta {
        background-color: var(--bg-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .meta-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .meta-text small {
        color: var(--text-muted);
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .meta-text span {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-dark);
    }
    .outcomes-list {
        list-style: none;
        padding-left: 0;
    }
    .outcomes-list li {
        margin-bottom: 12px;
        font-size: 0.95rem;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        line-height: 1.6;
    }
    .outcomes-list li i {
        color: var(--success);
        margin-top: 4px;
        font-size: 1.05rem;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="prog-hero">
    <div class="container">
        <h1>Our English Programs</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Explore our structured curricula designed to develop absolute beginners into fluent professional speakers and writers.</p>
    </div>
</section>

<!-- Programs List -->
<section class="section-padding">
    <div class="container" style="max-width: 960px;">
        
        @forelse($courses as $course)
        <div class="program-card" id="{{ Str::slug($course->name) }}">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #125875 0%, #1e3a8a 100%);">
                <h2>{{ $course->name }}</h2>
                <p class="mb-0 text-white-50">Course Code: {{ $course->code }}</p>
                <span class="program-badge">{{ $course->category }}</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>{{ $course->duration }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-hand-holding-usd"></i></div>
                                <div class="meta-text">
                                    <small>Tuition Fee</small>
                                    <span>${{ number_format($course->tuition_fee, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-check-double"></i></div>
                                <div class="meta-text">
                                    <small>Status</small>
                                    <span>Active Enrollments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>{{ $course->description }}</p>
                
                @if($course->outcomes)
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    @foreach(explode("\n", $course->outcomes) as $outcome)
                        @if(trim($outcome))
                        <li><i class="fas fa-check-circle"></i> {{ trim($outcome) }}</li>
                        @endif
                    @endforeach
                </ul>
                @endif
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">No academic programs are currently visible. Please check back later.</div>
        @endforelse

    </div>
</section>
@endsection
