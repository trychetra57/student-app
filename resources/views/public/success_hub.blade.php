@extends('layouts.public')

@section('title', 'Student Success Hub — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .success-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .success-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Testimonial Card */
    .testi-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 35px;
        margin-bottom: 30px;
        position: relative;
    }
    .quote-icon {
        position: absolute;
        top: 35px;
        right: 35px;
        font-size: 2.5rem;
        color: var(--primary-light);
        opacity: 0.5;
    }
    .student-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    .student-avatar {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.15rem;
    }
    .student-name h5 {
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 2px;
    }
    .student-name small {
        color: var(--text-muted);
        font-weight: 600;
    }
    .outcome-badge {
        background-color: #dcfce7;
        color: #15803d;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 15px;
    }

    /* Mock Video testimonial styling */
    .video-mock {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        height: 250px;
        background: linear-gradient(135deg, rgba(13, 63, 84, 0.8), rgba(255, 115, 80, 0.8)), 
                    url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop') no-repeat center center/cover;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .play-btn {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: white;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        cursor: pointer;
        transition: var(--transition);
        padding-left: 5px; /* offset play icon */
    }
    .video-mock:hover .play-btn {
        transform: scale(1.1);
        background-color: var(--accent);
        color: white;
    }

    /* Case Studies styling */
    .case-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 40px;
        margin-bottom: 40px;
    }
    .case-card h3 {
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 25px;
    }
    .case-step {
        margin-bottom: 20px;
    }
    .case-step h6 {
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 8px;
    }
    .case-step p {
        color: var(--text-muted);
        font-size: 0.92rem;
        line-height: 1.6;
        margin-bottom: 0;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="success-hero">
    <div class="container">
        <h1>Student Success Hub</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Explore outcome-based testimonials and case studies detailing how our programs guide students toward high GPAs, exam success, and career achievements.</p>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section-padding">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Outcome-Based Testimonials</h2>
            <p class="section-subtitle">Real students detailing explicit links between LEARN Academy and their academic/professional breakthroughs.</p>
        </div>
        
        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-lg-6">
                <div class="testi-card h-100">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="student-profile">
                        <div class="student-avatar">SK</div>
                        <div class="student-name">
                            <h5>Serey Kiri</h5>
                            <small>Graduate — University Survival English</small>
                        </div>
                    </div>
                    <div class="outcome-badge"><i class="fas fa-chart-line me-1"></i> GPA Improvement: 2.3 to 3.7</div>
                    <p class="text-secondary mb-0">"Before joining LEARN Academy, understanding university lectures in English was a daily nightmare. My first-year GPA dropped to 2.3. The intensive Survival English course taught me note-taking, active listening, and research referencing. By the second term, my grade point average jumped to 3.7!"</p>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="col-lg-6">
                <div class="testi-card h-100">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="student-profile">
                        <div class="student-avatar">MN</div>
                        <div class="student-name">
                            <h5>Monica Neary</h5>
                            <small>Graduate — English for Academic Writing</small>
                        </div>
                    </div>
                    <div class="outcome-badge"><i class="fas fa-graduation-cap me-1"></i> Received Exchange Scholarship</div>
                    <p class="text-secondary mb-0">"Writing formal research drafts was my biggest barrier to applying for scholarship funds. The Academic Writing syllabus broke down APA bibliography styles and logic structures. Thanks to my final thesis project at the Academy, I was accepted into the Australia Awards exchange program!"</p>
                </div>
            </div>

            <!-- Testimonial 3 (Video Mock) -->
            <div class="col-lg-6">
                <div class="video-mock">
                    <div class="play-btn" onclick="playMockVideo()"><i class="fas fa-play"></i></div>
                    <h5 class="fw-bold mb-1">Video Spotlight: Vichea's Business English Success</h5>
                    <small>Watch Vichea discuss how he secured an international manager position.</small>
                </div>
            </div>

            <!-- Testimonial 4 (Video Mock) -->
            <div class="col-lg-6">
                <div class="video-mock" style="background: linear-gradient(135deg, rgba(255, 115, 80, 0.8), rgba(1, 170, 89, 0.8)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=600&auto=format&fit=crop') no-repeat center center/cover;">
                    <div class="play-btn" onclick="playMockVideo()"><i class="fas fa-play"></i></div>
                    <h5 class="fw-bold mb-1">Video Spotlight: Sophy's Journey to IELTS Band 8.0</h5>
                    <small>Learn how Sophy improved her listening & speaking marks within 3 months.</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Student Case Studies Section -->
<section class="section-padding bg-light-custom" id="case-studies">
    <div class="container" style="max-width: 860px;">
        <div class="text-center">
            <h2 class="section-title">Student Case Studies</h2>
            <p class="section-subtitle">A deep dive into student growth paths, tracing their journey from academic struggle to high-level success.</p>
        </div>

        <!-- Case Study 1 -->
        <div class="case-card">
            <h3>Case Study 1: Sopheap's Journey from Lecture Silence to Boardroom Pitch Mastery</h3>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">Before</span>
                        <h5 class="text-danger fw-bold mb-0">Anxious / Silent</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">Program taken</span>
                        <h5 class="text-warning fw-bold mb-0">English for Business</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">After</span>
                        <h5 class="text-success fw-bold mb-0">Company Promotion</h5>
                    </div>
                </div>
            </div>
            
            <div class="case-step">
                <h6>The Challenge:</h6>
                <p>Sopheap, an accountant at a multinational logistics firm, struggled to communicate effectively during company calls. Despite having solid numerical skills, his lack of business English vocabulary and pronunciation anxiety kept him silent during boardroom presentations, missing out on major promotion opportunities.</p>
            </div>
            
            <div class="case-step">
                <h6>The Intervention:</h6>
                <p>Sopheap enrolled in our 10-week English for Business program. He participated in weekly pitch simulations, board meetings mock-ups, and corporate correspondence writing workshops. In addition, he booked twice-weekly Language Advising sessions to correct speech errors.</p>
            </div>

            <div class="case-step">
                <h6>The Result:</h6>
                <p>By week 8, Sopheap successfully delivered a 15-minute budget forecast proposal in front of native advisors. Two months after graduating, he led a regional sales pitch in English, securing a new contract and gaining promotion to Senior Accountant.</p>
            </div>
        </div>

        <!-- Case Study 2 -->
        <div class="case-card">
            <h3>Case Study 2: Borith's Transition from Struggling Freshman to Scholarship Excellence</h3>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">Before</span>
                        <h5 class="text-danger fw-bold mb-0">GPA: 1.9</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">Program taken</span>
                        <h5 class="text-warning fw-bold mb-0">Survival & Writing</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center" style="background-color:#fff;">
                        <span class="text-muted small d-block uppercase fw-bold">After</span>
                        <h5 class="text-success fw-bold mb-0">GPA: 3.8 / Scholarship</h5>
                    </div>
                </div>
            </div>
            
            <div class="case-step">
                <h6>The Challenge:</h6>
                <p>As a first-year student at an English-medium university, Borith felt completely lost. He could not write academic reviews or follow lecture note formats, causing his first-semester GPA to drop to a critical 1.9.</p>
            </div>
            
            <div class="case-step">
                <h6>The Intervention:</h6>
                <p>Borith completed both the University Survival English and English for Academic Writing courses sequentially. He spent 4 hours a week at the digital Self-access Center completing mock listening tests and grammar quiz files.</p>
            </div>

            <div class="case-step">
                <h6>The Result:</h6>
                <p>Borith's essays improved drastically, scoring A's in research essays. His GPA rose from 1.9 to 3.8 by the end of his sophomore year, earning him the prestigious President's Honor List scholarship award.</p>
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    function playMockVideo() {
        Swal.fire({
            title: 'Testimonial Video Clip',
            text: 'This video clip demonstrates outcome achievements of LEARN Academy alumni. (Mock player initialized successfully!)',
            icon: 'info',
            confirmButtonColor: '#125875',
            confirmButtonText: 'Great!'
        });
    }
</script>
@endsection
