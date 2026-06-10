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
        
        <!-- 1. University Survival English -->
        <div class="program-card" id="survival-english">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #125875 0%, #1e3a8a 100%);">
                <h2>University Survival English</h2>
                <p class="mb-0 text-white-50">Bridge the gap between high school and English-medium higher education.</p>
                <span class="program-badge">Academic Prep</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>10 Weeks (100 Hours)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
                                <div class="meta-text">
                                    <small>Level Required</small>
                                    <span>Lower Intermediate</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-users"></i></div>
                                <div class="meta-text">
                                    <small>Class Size</small>
                                    <span>Max 15 Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>Designed specifically for graduates and undergraduates entering English-taught university courses. This program builds the foundational academic capabilities required to thrive, focusing on speech comprehension, vocabulary development, note-taking strategies during live lectures, and seminar engagement.</p>
                
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    <li><i class="fas fa-check-circle"></i> Learn to extract core themes and map detailed structures of 45-minute academic lectures.</li>
                    <li><i class="fas fa-check-circle"></i> Expand vocabulary across major scientific, mathematical, and social disciplines.</li>
                    <li><i class="fas fa-check-circle"></i> Participate confidently in academic debates, voicing opinions and defending thesis statements.</li>
                    <li><i class="fas fa-check-circle"></i> Read and summarize journal reviews, reports, and textbook case studies.</li>
                </ul>
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>

        <!-- 2. NextGen English -->
        <div class="program-card" id="nextgen-english">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #0d3f54 0%, #125875 100%);">
                <h2>NextGen English</h2>
                <p class="mb-0 text-white-50">Modern English curriculum tailored for general fluency and vocabulary expansion.</p>
                <span class="program-badge">General English</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>12 Weeks (120 Hours)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
                                <div class="meta-text">
                                    <small>Level Required</small>
                                    <span>Beginner to Elementry</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-users"></i></div>
                                <div class="meta-text">
                                    <small>Class Size</small>
                                    <span>Max 20 Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>A comprehensive general English curriculum built for the next generation of students. We focus on immersion techniques, correcting pronunciation, eliminating grammar errors, and developing quick conversational responses. Ideal for building solid English habits from the ground up.</p>
                
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    <li><i class="fas fa-check-circle"></i> Master standard sentence construction patterns and crucial tenses (present, past, future).</li>
                    <li><i class="fas fa-check-circle"></i> Speak fluently on common topics (family, weather, hobbies, work) with accurate pronunciation.</li>
                    <li><i class="fas fa-check-circle"></i> Overcome public speaking anxiety through team dialogue and roleplay tasks.</li>
                    <li><i class="fas fa-check-circle"></i> Draft structured emails, personal journals, and descriptive reviews.</li>
                </ul>
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>

        <!-- 3. English Anytime Anywhere -->
        <div class="program-card" id="anytime-english">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #1f2937 0%, #0d3f54 100%);">
                <h2>English Anytime Anywhere</h2>
                <p class="mb-0 text-white-50">Flexible blended learning combining digital labs and active tutor panels.</p>
                <span class="program-badge">Blended / Flex</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>Self-Paced (Up to 6 Months)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
                                <div class="meta-text">
                                    <small>Level Required</small>
                                    <span>All Levels (A1 - C1)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-users"></i></div>
                                <div class="meta-text">
                                    <small>Class Size</small>
                                    <span>1-on-1 Advising Sessions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>Our premier flexible learning program built for busy students and professionals. Utilizing the custom LEARN Academy online learning dashboard, you complete grammar video lessons and tests at your own pace while attending scheduled weekly 1-on-1 feedback sessions with an English advisor.</p>
                
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    <li><i class="fas fa-check-circle"></i> Complete self-paced grammar, listening, and spelling lessons anywhere, on any device.</li>
                    <li><i class="fas fa-check-circle"></i> Join unlimited weekly conversation circles led by international tutors.</li>
                    <li><i class="fas fa-check-circle"></i> Receive customized feedback on pronunciation and syntax structure during 1-on-1 checkins.</li>
                    <li><i class="fas fa-check-circle"></i> Keep track of learning metrics, quiz history, and progress records via the portal.</li>
                </ul>
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>

        <!-- 4. English for Academic Writing -->
        <div class="program-card" id="academic-writing">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #115e59 0%, #125875 100%);">
                <h2>English for Academic Writing</h2>
                <p class="mb-0 text-white-50">Master the art of research, dissertation structures, and logical academic essays.</p>
                <span class="program-badge">Advanced Writing</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>8 Weeks (80 Hours)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
                                <div class="meta-text">
                                    <small>Level Required</small>
                                    <span>Upper Intermediate</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-users"></i></div>
                                <div class="meta-text">
                                    <small>Class Size</small>
                                    <span>Max 12 Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>Academic essays and graduation theses demand absolute accuracy and professional style. This course trains students to draft, structure, cite, and proofread high-level academic texts. Essential preparation for international scholarship submissions and master/doctoral studies.</p>
                
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    <li><i class="fas fa-check-circle"></i> Learn APA, Harvard, and Chicago citation styles to eliminate plagiarism risks.</li>
                    <li><i class="fas fa-check-circle"></i> Write clear literature reviews, thesis outlines, abstracts, and discussion segments.</li>
                    <li><i class="fas fa-check-circle"></i> Apply advanced transition devices and formal, passive sentence syntax structures.</li>
                    <li><i class="fas fa-check-circle"></i> Develop systematic editing, peer-reviewing, and proofreading processes.</li>
                </ul>
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>

        <!-- 5. English for Business -->
        <div class="program-card" id="business-english">
            <div class="program-header-banner" style="background: linear-gradient(135deg, #1e1b4b 0%, #125875 100%);">
                <h2>English for Business</h2>
                <p class="mb-0 text-white-50">Develop corporate communication skills, negotiations, and presentation mastery.</p>
                <span class="program-badge">Corporate / Professional</span>
            </div>
            <div class="program-body">
                <div class="program-meta">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="far fa-clock"></i></div>
                                <div class="meta-text">
                                    <small>Duration</small>
                                    <span>10 Weeks (90 Hours)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
                                <div class="meta-text">
                                    <small>Level Required</small>
                                    <span>Intermediate to Advanced</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="meta-item">
                                <div class="meta-icon"><i class="fas fa-users"></i></div>
                                <div class="meta-text">
                                    <small>Class Size</small>
                                    <span>Max 15 Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="fw-bold mb-3 text-primary">Course Description</h4>
                <p>Prepare yourself for the global marketplace. This program covers corporate correspondence, boardroom negotiation, business proposals, product presentations, and cross-cultural communication etiquette. Taught with simulation methodologies to duplicate corporate circumstances.</p>
                
                <h5 class="fw-bold mt-4 mb-3 text-primary">Key Learning Outcomes</h5>
                <ul class="outcomes-list">
                    <li><i class="fas fa-check-circle"></i> Master formal business writing: emails, executive summaries, agendas, and contracts.</li>
                    <li><i class="fas fa-check-circle"></i> Deliver persuasive pitches and project presentations with professional slides.</li>
                    <li><i class="fas fa-check-circle"></i> Learn negotiation strategies, counter-proposals, and conflict-resolution phrasing.</li>
                    <li><i class="fas fa-check-circle"></i> Analyze global business news and discuss market trends in fluent English.</li>
                </ul>
                
                <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold" style="border-radius: 30px;">Check Placement</a>
                    <a href="{{ route('placement-test') }}" class="btn btn-success fw-bold text-white px-4" style="background-color: var(--success); border: none; border-radius: 30px;">Enroll in Course</a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
