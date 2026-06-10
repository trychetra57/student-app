@extends('layouts.public')

@section('title', 'Student Services & Self-access — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .services-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1471&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .services-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Cards */
    .service-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 40px;
        margin-bottom: 30px;
        transition: var(--transition);
        height: 100%;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(18, 88, 117, 0.08);
    }
    .service-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 25px;
    }
    .service-card h3 {
        font-weight: 800;
        color: var(--primary);
        font-size: 1.4rem;
        margin-bottom: 15px;
    }

    /* Interactive Quiz Box */
    .quiz-box {
        background: white;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.06);
        border: 2px solid var(--primary-light);
        padding: 40px;
        margin-top: 50px;
    }
    .quiz-title {
        font-weight: 800;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }
    .quiz-title i {
        color: var(--accent);
    }
    .quiz-option {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .quiz-option:hover {
        background-color: var(--bg-light);
        border-color: #cbd5e1;
    }
    .quiz-option.selected {
        background-color: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }
    .quiz-option.correct {
        background-color: #dcfce7;
        border-color: var(--success);
        color: #15803d;
    }
    .quiz-option.incorrect {
        background-color: #ffe4e6;
        border-color: var(--accent);
        color: #be123c;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="services-hero">
    <div class="container">
        <h1>Student & Staff Services</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Discover our comprehensive counseling advising systems, internship programs, and self-access multimedia platforms.</p>
    </div>
</section>

<!-- Services Sections -->
<section class="section-padding" id="language-support">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Language Support Programs</h2>
            <p class="section-subtitle">Struggling with speaking or formatting academic essays? Benefit from our customized support services.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-comments-dollar"></i></div>
                    <h3>Language Advising Service (LAS)</h3>
                    <p class="text-secondary">Our Language Advising Service allows you to book 30-minute private 1-on-1 consultations with our certified advisors. They evaluate your essay drafts, correct speech habits, point out systematic grammar flaws, and build a tailored study tracker to ensure you reach class benchmarks.</p>
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-primary fw-bold px-4 mt-3" style="border-radius:30px;">Book Advising Session</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-users-viewfinder"></i></div>
                    <h3>Peer Teaching Program</h3>
                    <p class="text-secondary">Study collaboratively! Through our Peer Teaching program, advanced students of Academic Writing and Business English courses lead smaller study groups for beginners. This creates an inviting conversational atmosphere where you practice homework tasks, review vocabulary, and exchange study habits.</p>
                    <span class="badge bg-success py-2 px-3 fw-bold mt-3" style="border-radius:20px;">Free For Enrolled Students</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Self Access Center Section -->
<section class="section-padding bg-light-custom" id="self-access">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="fw-bold text-primary mb-3">Self-access Center (SAC)</h2>
                <p class="text-secondary lead">Maximize your study efficiency outside the classroom with our interactive digital library and mock test labs.</p>
                <p>The Self-access Center is equipped with computers, listening suites, mock tests, vocabulary decks, and Khmer-English translation guides. Open every day for self-study practice sessions.</p>
                <div class="d-flex gap-3 flex-wrap mt-4">
                    <div class="bg-white border rounded-3 p-3 text-center flex-fill">
                        <h4 class="fw-bold text-primary mb-1">5000+</h4>
                        <small class="text-muted">Grammar Worksheets</small>
                    </div>
                    <div class="bg-white border rounded-3 p-3 text-center flex-fill">
                        <h4 class="fw-bold text-primary mb-1">200+</h4>
                        <small class="text-muted">Practice Quizzes</small>
                    </div>
                    <div class="bg-white border rounded-3 p-3 text-center flex-fill">
                        <h4 class="fw-bold text-primary mb-1">50+</h4>
                        <small class="text-muted">Mock IELTS Exams</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <!-- Interactive Mini Quiz -->
                <div class="quiz-box" id="miniQuiz">
                    <h4 class="quiz-title"><i class="fas fa-brain"></i> Quick Self-access Quiz</h4>
                    <p class="text-secondary small mb-4">Practice on the spot! Choose the correct verb form below to check your level.</p>
                    
                    <div class="quiz-question-wrapper" id="questionBox">
                        <h6 class="fw-bold mb-3" id="quizQuestion">She ___ English fluently because she practices every day.</h6>
                        <div class="quiz-options">
                            <div class="quiz-option" onclick="checkAnswer(this, 'a')">
                                <span class="badge bg-secondary">A</span> speak
                            </div>
                            <div class="quiz-option" onclick="checkAnswer(this, 'b')">
                                <span class="badge bg-secondary">B</span> speaks
                            </div>
                            <div class="quiz-option" onclick="checkAnswer(this, 'c')">
                                <span class="badge bg-secondary">C</span> speaking
                            </div>
                            <div class="quiz-option" onclick="checkAnswer(this, 'd')">
                                <span class="badge bg-secondary">D</span> spoken
                            </div>
                        </div>
                        <div class="mt-4 text-center d-none" id="quizFeedback">
                            <h6 class="fw-bold" id="feedbackTitle">Correct!</h6>
                            <p class="small text-muted mb-0" id="feedbackText">"Speaks" is the correct third-person singular present form of the verb "to speak".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Internship & Professional Dev -->
<section class="section-padding" id="internships">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Career & Growth Programs</h2>
            <p class="section-subtitle">We invest in our student body and staff members to ensure long-term professional success.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6" id="internship-info">
                <div class="service-card">
                    <div class="service-icon" style="background-color: #dcfce7; color: var(--success);"><i class="fas fa-briefcase"></i></div>
                    <h3>Student Internship Program</h3>
                    <p class="text-secondary">Outstanding students enrolled in English for Business and Academic Writing can apply for our 3-month Internship. You will work in administrative assistance, class co-tutoring, event organization, or peer advisory roles, building critical boardroom experience and receiving a official reference letter.</p>
                </div>
            </div>
            <div class="col-md-6" id="staff-development">
                <div class="service-card">
                    <div class="service-icon" style="background-color: #ede9fe; color: #5b21b6;"><i class="fas fa-chalkboard-user"></i></div>
                    <h3>Staff Professional Development</h3>
                    <p class="text-secondary">We run mandatory monthly development seminars for our academic staff. The workshops cover innovative immersion lecturing methodologies, digital grading tools, diagnostic feedback skills, and standard syllabus editing to guarantee classroom delivery remains premium.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function checkAnswer(element, answer) {
        // Prevent multi clicks
        const options = document.querySelectorAll('.quiz-option');
        options.forEach(opt => opt.onclick = null);

        if (answer === 'b') {
            element.classList.add('correct');
            document.getElementById('quizFeedback').classList.remove('d-none');
            document.getElementById('feedbackTitle').innerText = 'Correct!';
            document.getElementById('feedbackTitle').className = 'fw-bold text-success';
        } else {
            element.classList.add('incorrect');
            // Highlight correct one too
            options.forEach(opt => {
                if (opt.innerText.includes('speaks') || opt.innerText.includes('B')) {
                    opt.classList.add('correct');
                }
            });
            document.getElementById('quizFeedback').classList.remove('d-none');
            document.getElementById('feedbackTitle').innerText = 'Try Again!';
            document.getElementById('feedbackTitle').className = 'fw-bold text-danger';
            document.getElementById('feedbackText').innerText = 'The third-person singular pronoun "she" requires the verb form "speaks" in the present simple tense.';
        }
    }
</script>
@endsection
