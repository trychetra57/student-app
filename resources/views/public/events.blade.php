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
        
        <!-- Event 1 -->
        <div class="event-detail-card">
            <div class="row g-0">
                <div class="col-md-5 event-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop" alt="Speaking Contest">
                    <div class="event-date-badge">July 10, 2026</div>
                </div>
                <div class="col-md-7">
                    <div class="event-info">
                        <span class="badge bg-warning text-dark px-3 py-1 mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">Contest / Competition</span>
                        <h3>LEARN Public Speaking Championship 2026</h3>
                        <p>Our flagship yearly competition is here. Open to all registered students, candidates will pitch ideas in front of a panel of corporate managers and native English lecturers. The grand winner receives a full term tuition scholarship and an internship referral certificate.</p>
                        <div class="d-flex align-items-center gap-2 mt-4 text-primary fw-bold">
                            <i class="far fa-clock"></i> <span>2:00 PM — 5:00 PM</span>
                            <span class="mx-2">&bull;</span>
                            <i class="fas fa-map-pin"></i> <span>Main Hall A, Sen Sok Campus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event 2 -->
        <div class="event-detail-card">
            <div class="row g-0">
                <div class="col-md-5 event-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop" alt="Webinar">
                    <div class="event-date-badge">July 25, 2026</div>
                </div>
                <div class="col-md-7">
                    <div class="event-info">
                        <span class="badge bg-success text-white px-3 py-1 mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">Workshop</span>
                        <h3>Academic Writing Styles & Citation Guidelines</h3>
                        <p>Academic Writing demands strict citation formats. This webinar covers practical tips for using APA 7th edition, structuring research hypothesis sheets, organizing bibliography catalogs, and keeping paragraphs logically unified to earn high marks.</p>
                        <div class="d-flex align-items-center gap-2 mt-4 text-primary fw-bold">
                            <i class="far fa-clock"></i> <span>9:30 AM — 11:30 AM</span>
                            <span class="mx-2">&bull;</span>
                            <i class="fas fa-video"></i> <span>Live Zoom Broadcast</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event 3 -->
        <div class="event-detail-card">
            <div class="row g-0">
                <div class="col-md-5 event-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=400&auto=format&fit=crop" alt="Rebranding Day">
                    <div class="event-date-badge">June 20, 2026</div>
                </div>
                <div class="col-md-7">
                    <div class="event-info">
                        <span class="badge bg-info text-white px-3 py-1 mb-2 text-uppercase fw-bold" style="font-size: 0.7rem;">Inauguration</span>
                        <h3>Campus Grand Rebranding & Open Day</h3>
                        <p>Come tour our redesigned classrooms, computer labs, and the Self-access Learning Center. Meet the course advisors, take a free placement test on-site, and get special 20% discount vouchers for Term 2 enrollment.</p>
                        <div class="d-flex align-items-center gap-2 mt-4 text-primary fw-bold">
                            <i class="far fa-clock"></i> <span>8:00 AM — 4:00 PM</span>
                            <span class="mx-2">&bull;</span>
                            <i class="fas fa-map-pin"></i> <span>Sen Sok Campus Plaza</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
