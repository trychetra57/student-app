@extends('layouts.public')

@section('title', 'LEARN Academy — Premium English Language Programs')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        color: white;
        padding: 0;
        position: relative;
        overflow: hidden;
    }
    .hero-slide {
        padding: 120px 0 100px;
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        min-height: 550px;
        display: flex;
        align-items: center;
    }
    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 25px;
        background: linear-gradient(to right, #ffffff, #ff9e85);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-content p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 40px;
        font-weight: 400;
    }

    /* Promotional Flyer Card */
    .promo-flyer {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        color: var(--text-dark);
        border-top: 6px solid var(--accent);
        transform: translateY(10px);
        animation: float 4s ease-in-out infinite;
        position: relative;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .promo-badge {
        background-color: var(--accent);
        color: white;
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.8rem;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(255, 115, 80, 0.3);
    }
    .promo-flyer h3 {
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--primary);
        margin-bottom: 12px;
    }
    .promo-flyer ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 25px;
    }
    .promo-flyer ul li {
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .promo-flyer ul li i {
        color: var(--success);
    }

    /* Value Proposition Section */
    .val-prop-card {
        background: white;
        border-radius: 20px;
        padding: 35px 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(18, 88, 117, 0.05);
        transition: var(--transition);
        height: 100%;
        text-align: center;
    }
    .val-prop-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(18, 88, 117, 0.1);
        border-color: rgba(18, 88, 117, 0.15);
    }
    .val-prop-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 25px;
        transition: var(--transition);
    }
    .val-prop-card:hover .val-prop-icon {
        background-color: var(--accent);
        color: white;
        transform: rotateY(180deg);
    }
    .val-prop-card h4 {
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 15px;
        color: var(--primary);
    }

    /* About Section */
    .about-card {
        border-radius: 20px;
        padding: 30px;
        border: none;
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        background: white;
        height: 100%;
        transition: var(--transition);
    }
    .about-card:hover {
        box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    }
    .about-card h5 {
        font-weight: 800;
        color: var(--primary);
        font-size: 1.3rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .about-card h5 i {
        color: var(--accent);
    }

    /* Facilities Gallery */
    .facility-item {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        cursor: pointer;
        height: 250px;
    }
    .facility-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .facility-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(13, 63, 84, 0.9) 0%, rgba(13, 63, 84, 0.2) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px;
        opacity: 0;
        transition: var(--transition);
    }
    .facility-item:hover img {
        transform: scale(1.1);
    }
    .facility-item:hover .facility-overlay {
        opacity: 1;
    }
    .facility-overlay h5 {
        color: white;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .facility-overlay p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        margin: 0;
    }

    /* Contact Form card */
    .contact-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.08);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 40px;
    }
    .contact-card h3 {
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 30px;
    }
</style>
@endsection

@section('content')
<!-- ── Hero Section with Dynamic Sliders ── -->
<section class="hero-section">
    @if($sliders->count() > 0)
        <div id="homepageCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($sliders as $index => $slide)
                    <button type="button" data-bs-target="#homepageCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliders as $index => $slide)
                    @php
                        $imgPath = Str::startsWith($slide->image_path, 'http') ? $slide->image_path : asset($slide->image_path);
                    @endphp
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="6000">
                        <div class="hero-slide" style="background: linear-gradient(135deg, rgba(18, 88, 117, 0.92) 0%, rgba(13, 63, 84, 0.85) 100%), url('{{ $imgPath }}');">
                            <div class="container">
                                <div class="row align-items-center g-5">
                                    <div class="col-lg-7 hero-content">
                                        <span class="badge bg-danger px-3 py-2 mb-3 text-uppercase font-weight-bold" style="font-size:0.8rem; letter-spacing:1px;">New Semester Admissions Open</span>
                                        <h1>{{ $slide->title }}</h1>
                                        <p>{{ $slide->subtitle }}</p>
                                        <div class="d-flex gap-3 flex-wrap">
                                            <a href="{{ $slide->target_url ?: route('placement-test') }}" class="btn btn-warning btn-lg px-4 py-3 text-white fw-bold shadow border-0" style="background-color: var(--accent); border-radius: 30px;">
                                                <i class="fas fa-arrow-right me-2"></i> Get Started
                                            </a>
                                            <a href="#about-us" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold" style="border-radius: 30px;">
                                                <i class="fas fa-info-circle me-2"></i> Learn More
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <!-- Promo Flyer -->
                                        <div class="promo-flyer">
                                            <div class="promo-badge">Special Rebranding Offer</div>
                                            <h3>Enroll & Save Up to 20%</h3>
                                            <p class="text-secondary">To celebrate our brand new academic structure at LEARN Academy, we are giving exclusive benefits to new students:</p>
                                            <ul>
                                                <li><i class="fas fa-check-circle"></i> 20% Off Tuition Fee for Term 1</li>
                                                <li><i class="fas fa-check-circle"></i> Free English Placement Test</li>
                                                <li><i class="fas fa-check-circle"></i> Complimentary Access to Self-access Labs</li>
                                                <li><i class="fas fa-check-circle"></i> Learn with UK/US Native Lecturers</li>
                                            </ul>
                                            <a href="{{ route('placement-test') }}" class="btn btn-success btn-lg w-100 py-3 fw-bold border-0" style="border-radius: 12px; background-color: var(--success);">
                                                <i class="fas fa-arrow-right me-2"></i> Claim Rebranding Offer Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @else
        <!-- Fallback static hero section -->
        <div class="hero-slide" style="background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1470&auto=format&fit=crop');">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7 hero-content">
                        <span class="badge bg-danger px-3 py-2 mb-3 text-uppercase font-weight-bold" style="font-size:0.8rem; letter-spacing:1px;">New Semester 2026 Admissions Open</span>
                        <h1>Transform Your Future With Expert English Proficiency</h1>
                        <p>Welcome to LEARN Academy, the kingdom's top language institution. We build practical communication skills, business speaking capabilities, and academic writing mastery with modern certified courses.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('placement-test') }}" class="btn btn-warning btn-lg px-4 py-3 text-white fw-bold shadow border-0" style="background-color: var(--accent); border-radius: 30px;">
                                <i class="fas fa-clipboard-list me-2"></i> Free Placement Test
                            </a>
                            <a href="#about-us" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold" style="border-radius: 30px;">
                                <i class="fas fa-info-circle me-2"></i> Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

<!-- ── Quick Portal Access ── -->
<section class="py-5 bg-light-custom border-bottom">
    <div class="container">
        <div class="row align-items-center text-center text-md-start g-3">
            <div class="col-md-8">
                <h5 class="fw-bold mb-1" style="color: var(--primary);">Already a registered student at LEARN Academy?</h5>
                <p class="text-muted mb-0">Access your academic transcripts, schedule courses, view classes, and manage your student profile.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-bold" style="border-radius: 30px;">
                    <i class="fas fa-sign-in-alt me-1"></i> Student Portal Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary px-4 py-2 fw-bold ms-2" style="border-radius: 30px;">
                    Register
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ── Value Proposition Section ── -->
<section class="section-padding" id="value-proposition">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Why LEARN Academy?</h2>
            <p class="section-subtitle">We design our language modules with outcome-based standards, guaranteeing maximum academic growth and speaking confidence.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="val-prop-card">
                    <div class="val-prop-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4>{{ $settings['value_1_title'] }}</h4>
                    <p class="text-muted mb-0">{{ $settings['value_1_description'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="val-prop-card">
                    <div class="val-prop-icon">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h4>{{ $settings['value_2_title'] }}</h4>
                    <p class="text-muted mb-0">{{ $settings['value_2_description'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="val-prop-card">
                    <div class="val-prop-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <h4>{{ $settings['value_3_title'] }}</h4>
                    <p class="text-muted mb-0">{{ $settings['value_3_description'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── About Us, Mission, Vision ── -->
<section class="section-padding bg-light-custom" id="about-us">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">About Us</h2>
            <p class="section-subtitle">Learn more about our core values, mission statement, and vision for language education in the region.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="about-card">
                    <h5><i class="fas fa-graduation-cap"></i> Our Identity</h5>
                    <p class="text-muted mb-0">{{ $settings['about_us_text'] }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card">
                    <h5><i class="fas fa-bullseye"></i> Our Mission</h5>
                    <p class="text-muted mb-0">{{ $settings['mission'] }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card">
                    <h5><i class="fas fa-eye"></i> Our Vision</h5>
                    <p class="text-muted mb-0">{{ $settings['vision'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Location & Facilities ── -->
<section class="section-padding" id="facilities">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Location & Facilities</h2>
            <p class="section-subtitle">Tour our state-of-the-art campus featuring modern tech-equipped classrooms and learning spaces.</p>
        </div>
        <div class="row g-3">
            @forelse($gallery->take(3) as $item)
                @php
                    $imgPath = Str::startsWith($item->image_path, 'http') ? $item->image_path : asset($item->image_path);
                @endphp
                <div class="col-md-4">
                    <div class="facility-item">
                        <img src="{{ $imgPath }}" alt="{{ $item->title }}">
                        <div class="facility-overlay">
                            <h5>{{ $item->title }}</h5>
                            <p>{{ $item->category }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4">
                    <div class="facility-item">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop" alt="Classroom">
                        <div class="facility-overlay">
                            <h5>Interactive Classrooms</h5>
                            <p>Tech-equipped spaces designed for collaborative workshops and active lecturing.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="facility-item">
                        <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=600&auto=format&fit=crop" alt="Library">
                        <div class="facility-overlay">
                            <h5>Self-Access Resource Center</h5>
                            <p>Fully stocked digital library with grammar worksheets, mock exams, and quiz portals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="facility-item">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop" alt="Computer Lab">
                        <div class="facility-overlay">
                            <h5>Multimedia Lab</h5>
                            <p>Computer suites featuring specialized pronunciation software and recording tools.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Maps / Location -->
        <div class="row mt-5 align-items-center g-4">
            <div class="col-lg-6">
                <h4 class="fw-bold mb-3 text-primary"><i class="fas fa-location-arrow me-2 text-warning"></i>Our Campus Location</h4>
                <p>Located in the heart of Sen Sok, Phnom Penh, our campus offers convenient access, spacious parking, and a peaceful environment optimal for student focus.</p>
                <p class="fw-semibold text-secondary"><i class="far fa-clock me-2"></i>Hours: Mon - Fri (7:30 AM - 8:30 PM), Sat - Sun (8:00 AM - 5:00 PM)</p>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-21x9 rounded-3 overflow-hidden shadow border" style="background-color:#e2e8f0; display:flex; align-items:center; justify-content:center;">
                    <div class="text-center p-3">
                        <i class="fas fa-map-marked-alt text-primary mb-2" style="font-size:2rem;"></i>
                        <h6 class="fw-bold mb-0">LEARN Academy Sen Sok Campus</h6>
                        <small class="text-muted">#125, Street 2004, Phnom Penh</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Event Highlights ── -->
<section class="section-padding bg-light-custom" id="events">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Event Highlights</h2>
            <p class="section-subtitle">Catch up on recent updates, seminar highlights, and student events at LEARN Academy.</p>
        </div>
        <div class="row g-4">
            @forelse($news as $article)
                @php
                    $newsImg = $article->image_path ? (Str::startsWith($article->image_path, 'http') ? $article->image_path : asset($article->image_path)) : 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=400&auto=format&fit=crop';
                @endphp
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <img src="{{ $newsImg }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <small class="text-warning fw-bold text-uppercase" style="font-size:0.75rem;">{{ $article->category }}</small>
                            <h5 class="fw-bold mt-2 mb-3 text-primary">{{ $article->title }}</h5>
                            <p class="text-muted small">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                            <a href="{{ route('events') }}#article-{{ $article->id }}" class="text-primary fw-semibold small text-decoration-none">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop" class="card-img-top" alt="English Speaking Contest">
                        <div class="card-body">
                            <small class="text-warning fw-bold text-uppercase" style="font-size:0.75rem;">Contest</small>
                            <h5 class="fw-bold mt-2 mb-3 text-primary">Annual Public Speaking Contest 2026</h5>
                            <p class="text-muted small">Over 50 candidates from our Business English and Advanced Academic Writing courses competed for the Grand Trophy.</p>
                            <a href="{{ route('events') }}" class="text-primary fw-semibold small text-decoration-none">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop" class="card-img-top" alt="Guest Lecture">
                        <div class="card-body">
                            <small class="text-warning fw-bold text-uppercase" style="font-size:0.75rem;">Workshop</small>
                            <h5 class="fw-bold mt-2 mb-3 text-primary">Academic Writing Seminar by Prof. Henderson</h5>
                            <p class="text-muted small">A specialized workshop focusing on dissertation thesis structure, citation formatting, and grammar styles.</p>
                            <a href="{{ route('events') }}" class="text-primary fw-semibold small text-decoration-none">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=400&auto=format&fit=crop" class="card-img-top" alt="Rebranding ceremony">
                        <div class="card-body">
                            <small class="text-warning fw-bold text-uppercase" style="font-size:0.75rem;">Ceremony</small>
                            <h5 class="fw-bold mt-2 mb-3 text-primary">Grand Rebranding & Campus Launch</h5>
                            <p class="text-muted small">Inauguration ceremony showcasing our newly designed classrooms, self-access learning centers, and placement platforms.</p>
                            <a href="{{ route('events') }}" class="text-primary fw-semibold small text-decoration-none">Read more <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ── Contact Us ── -->
<section class="section-padding" id="contact-us">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h2 class="fw-bold text-primary mb-3">Get in Touch</h2>
                <p>Have questions about tuition fees, upcoming term dates, or class schedules? Send us a message and our academic advisors will get back to you within 24 hours.</p>
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="width:45px; height:45px; border-radius:50%; background-color:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:1.1rem;"><i class="fas fa-envelope"></i></div>
                        <div>
                            <small class="text-muted d-block">Email Us</small>
                            <span class="fw-bold text-primary">admission@learnacademy.edu.kh</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="width:45px; height:45px; border-radius:50%; background-color:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:1.1rem;"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <small class="text-muted d-block">Call Helpline</small>
                            <span class="fw-bold text-primary">+855 (0) 23 888 777</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="contact-card">
                    <h3>Send Message</h3>
                    <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="e.g. john@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required placeholder="e.g. Course enrollment query">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Type your inquiry details here..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold border-0" style="background-color:var(--primary); border-radius:12px;">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
