@extends('layouts.public')

@section('title', 'English Placement Test — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .test-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=1473&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .test-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Test Cards */
    .test-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.06);
        border: 1px solid rgba(18, 88, 117, 0.05);
        padding: 40px;
    }
    .q-number {
        background-color: var(--primary-light);
        color: var(--primary);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        margin-right: 10px;
    }
    .question-group {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 25px;
        margin-bottom: 25px;
    }
    .question-group:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    /* Result Panel */
    .result-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        border-top: 8px solid var(--success);
        padding: 50px;
        text-align: center;
    }
    .score-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        box-shadow: 0 8px 25px rgba(18, 88, 117, 0.15);
    }
    .score-circle .number {
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1;
    }
    .score-circle .label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="test-hero">
    <div class="container">
        <h1>Test Your English</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Take our diagnostic language placement test. Our automated system calculates your grammar/vocabulary proficiency and recommends courses.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container" style="max-width: 800px;">
        
        @if(session('test_submitted'))
            <!-- ── Result Card ── -->
            <div class="result-card fade-in-up">
                <div class="score-circle">
                    <span class="number">{{ session('score') }}</span>
                    <span class="label">out of {{ session('total') }}</span>
                </div>
                
                <span class="badge bg-success px-3 py-2 mb-3 text-uppercase fw-bold" style="font-size:0.8rem;">Evaluation: {{ session('level') }}</span>
                <h2 class="fw-bold text-primary mb-3">Recommended Program:</h2>
                <h3 class="fw-extrabold text-warning mb-4" style="color: var(--accent) !important; font-size:1.8rem;">{{ session('recommendation') }}</h3>
                
                <p class="text-secondary max-width-600 mx-auto mb-5" style="line-height:1.7;">{{ session('description') }}</p>
                
                <div class="card bg-light-custom border-0 p-4 rounded-3 text-start mb-5" style="max-width:600px; margin: 0 auto;">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-clipboard-list text-warning me-2"></i>Next Steps:</h5>
                    <ol class="mb-0 text-secondary" style="font-size:0.9rem; line-height:1.7;">
                        <li class="mb-2">Click <strong>Register to Student Portal</strong> below and create a password.</li>
                        <li class="mb-2">Your test score of <strong>{{ session('score') }}/{{ session('total') }}</strong> has been saved under your profile automatically.</li>
                        <li>An advisor will contact you to confirm class timetable availability.</li>
                    </ol>
                </div>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold" style="background-color:var(--success); border:none; border-radius:30px;">
                        <i class="fas fa-user-plus me-1"></i> Register Student Account
                    </a>
                    <a href="{{ route('placement-test') }}" class="btn btn-outline-secondary btn-lg px-4 py-3 fw-bold" style="border-radius:30px;">
                        <i class="fas fa-redo me-1"></i> Retake Test
                    </a>
                </div>
            </div>
        @else
            <!-- ── Test Form ── -->
            <div class="test-card fade-in-up">
                <form action="{{ route('placement-test.submit') }}" method="POST">
                    @csrf
                    
                    <!-- Candidate Info -->
                    <div class="card border-0 bg-light-custom p-4 rounded-3 mb-5">
                        <h5 class="fw-bold text-primary mb-3"><i class="far fa-user me-2 text-warning"></i>Candidate Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="cand_name">Full Name</label>
                                <input type="text" class="form-control bg-white" id="cand_name" name="name" required placeholder="e.g. John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="cand_email">Email Address</label>
                                <input type="email" class="form-control bg-white" id="cand_email" name="email" required placeholder="e.g. john@example.com">
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Multiple-Choice Questions</h4>

                    <!-- Question 1 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">1</span>She ___ to school every day.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q1]" value="a" id="q1a" required>
                            <label class="form-check-label" for="q1a">go</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q1]" value="b" id="q1b">
                            <label class="form-check-label" for="q1b">goes</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q1]" value="c" id="q1c">
                            <label class="form-check-label" for="q1c">going</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q1]" value="d" id="q1d">
                            <label class="form-check-label" for="q1d">gone</label>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">2</span>They have ___ finished their homework.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q2]" value="a" id="q2a" required>
                            <label class="form-check-label" for="q2a">yet</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q2]" value="b" id="q2b">
                            <label class="form-check-label" for="q2b">still</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q2]" value="c" id="q2c">
                            <label class="form-check-label" for="q2c">already</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q2]" value="d" id="q2d">
                            <label class="form-check-label" for="q2d">since</label>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">3</span>If it ___ tomorrow, we will cancel the picnic.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q3]" value="a" id="q3a" required>
                            <label class="form-check-label" for="q3a">rains</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q3]" value="b" id="q3b">
                            <label class="form-check-label" for="q3b">rain</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q3]" value="c" id="q3c">
                            <label class="form-check-label" for="q3c">will rain</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q3]" value="d" id="q3d">
                            <label class="form-check-label" for="q3d">rained</label>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">4</span>The book ___ by a famous author last year.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q4]" value="a" id="q4a" required>
                            <label class="form-check-label" for="q4a">wrote</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q4]" value="b" id="q4b">
                            <label class="form-check-label" for="q4b">written</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q4]" value="c" id="q4c">
                            <label class="form-check-label" for="q4c">is writing</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q4]" value="d" id="q4d">
                            <label class="form-check-label" for="q4d">was written</label>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">5</span>I look forward to ___ you soon.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q5]" value="a" id="q5a" required>
                            <label class="form-check-label" for="q5a">see</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q5]" value="b" id="q5b">
                            <label class="form-check-label" for="q5b">seeing</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q5]" value="c" id="q5c">
                            <label class="form-check-label" for="q5c">seen</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q5]" value="d" id="q5d">
                            <label class="form-check-label" for="q5d">saw</label>
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">6</span>By the time he arrived, the class ___ already started.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q6]" value="a" id="q6a" required>
                            <label class="form-check-label" for="q6a">has</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q6]" value="b" id="q6b">
                            <label class="form-check-label" for="q6b">is</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q6]" value="c" id="q6c">
                            <label class="form-check-label" for="q6c">had</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q6]" value="d" id="q6d">
                            <label class="form-check-label" for="q6d">was</label>
                        </div>
                    </div>

                    <!-- Question 7 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">7</span>She speaks English fluently, ___?</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q7]" value="a" id="q7a" required>
                            <label class="form-check-label" for="q7a">doesn't she</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q7]" value="b" id="q7b">
                            <label class="form-check-label" for="q7b">isn't she</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q7]" value="c" id="q7c">
                            <label class="form-check-label" for="q7c">doesn't speaks she</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q7]" value="d" id="q7d">
                            <label class="form-check-label" for="q7d">does she</label>
                        </div>
                    </div>

                    <!-- Question 8 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">8</span>I wish I ___ more time to study last week.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q8]" value="a" id="q8a" required>
                            <label class="form-check-label" for="q8a">have</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q8]" value="b" id="q8b">
                            <label class="form-check-label" for="q8b">had</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q8]" value="c" id="q8c">
                            <label class="form-check-label" for="q8c">would have</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q8]" value="d" id="q8d">
                            <label class="form-check-label" for="q8d">had had</label>
                        </div>
                    </div>

                    <!-- Question 9 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">9</span>Notwithstanding the rain, they ___ playing soccer.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q9]" value="a" id="q9a" required>
                            <label class="form-check-label" for="q9a">quit</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q9]" value="b" id="q9b">
                            <label class="form-check-label" for="q9b">continued</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q9]" value="c" id="q9c">
                            <label class="form-check-label" for="q9c">stopped</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q9]" value="d" id="q9d">
                            <label class="form-check-label" for="q9d">finished</label>
                        </div>
                    </div>

                    <!-- Question 10 -->
                    <div class="question-group">
                        <h6 class="fw-bold mb-3"><span class="q-number">10</span>Had I known about the test, I ___ harder.</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q10]" value="a" id="q10a" required>
                            <label class="form-check-label" for="q10a">will study</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q10]" value="b" id="q10b">
                            <label class="form-check-label" for="q10b">would study</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q10]" value="c" id="q10c">
                            <label class="form-check-label" for="q10c">would have studied</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[q10]" value="d" id="q10d">
                            <label class="form-check-label" for="q10d">had studied</label>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 fw-bold" style="border-radius:30px;">
                            <i class="fas fa-paper-plane me-2"></i> Submit and Evaluate
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</section>
@endsection
