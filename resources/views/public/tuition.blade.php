@extends('layouts.public')

@section('title', 'Tuition Fees & Key Dates — LEARN Academy')

@section('styles')
<style>
    /* Hero */
    .fee-hero {
        background: linear-gradient(135deg, rgba(18, 88, 117, 0.95) 0%, rgba(13, 63, 84, 0.9) 100%), 
                    url('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
    .fee-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    /* Tuition Table Styling */
    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid rgba(18, 88, 117, 0.05);
        overflow: hidden;
        margin-bottom: 50px;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom th {
        background-color: var(--primary);
        color: white;
        font-weight: 700;
        padding: 20px 24px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    .table-custom td {
        padding: 20px 24px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-weight: 600;
    }
    .table-custom tr:hover {
        background-color: var(--bg-light);
    }
    .fee-amount {
        color: var(--primary);
        font-size: 1.2rem;
        font-weight: 800;
    }

    /* Timeline styling */
    .timeline-container {
        position: relative;
        padding-left: 30px;
        margin-bottom: 50px;
    }
    .timeline-container::before {
        content: '';
        position: absolute;
        left: 9px;
        top: 5px;
        bottom: 5px;
        width: 2px;
        background-color: #cbd5e1;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 35px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: white;
        border: 4px solid var(--accent);
        box-shadow: 0 0 0 4px var(--primary-light);
        z-index: 2;
    }
    .timeline-item.completed::before {
        border-color: var(--success);
        box-shadow: 0 0 0 4px #dcfce7;
    }
    .timeline-date {
        font-weight: 800;
        color: var(--accent);
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .timeline-content {
        background-color: var(--bg-light);
        border-radius: 16px;
        padding: 20px 25px;
        border: 1px solid rgba(18, 88, 117, 0.05);
    }
    .timeline-content h5 {
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 8px;
    }
    .timeline-content p {
        margin-bottom: 0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="fee-hero">
    <div class="container">
        <h1>Tuition Fees & Key Dates</h1>
        <p class="lead text-white-50 max-width-700 mx-auto">Review detailed course pricing structures, upcoming term intakes, and scholarship payment schedules.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Left Side: Tuition Fees -->
            <div class="col-lg-7">
                <h3 class="fw-bold text-primary mb-4"><i class="fas fa-wallet me-2 text-warning"></i>Tuition Fees (Term 2, 2026)</h3>
                <p class="mb-4">LEARN Academy operates transparent tuition schedules. Fees include complete physical learning manuals, online test resources, advising sessions, and self-access multimedia room licenses.</p>
                
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Program Title</th>
                                    <th>Duration</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-bold">University Survival English</div>
                                        <small class="text-muted">Academic preparation course</small>
                                    </td>
                                    <td>10 Weeks</td>
                                    <td><span class="fee-amount">$320</span> <small class="text-muted">/ term</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-bold">NextGen English</div>
                                        <small class="text-muted">Foundational speaking & grammar</small>
                                    </td>
                                    <td>12 Weeks</td>
                                    <td><span class="fee-amount">$290</span> <small class="text-muted">/ term</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-bold">English Anytime Anywhere</div>
                                        <small class="text-muted">Blended, flex self-study model</small>
                                    </td>
                                    <td>6 Months</td>
                                    <td><span class="fee-amount">$380</span> <small class="text-muted">/ term</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-bold">English for Academic Writing</div>
                                        <small class="text-muted">Advanced citations & thesis style</small>
                                    </td>
                                    <td>8 Weeks</td>
                                    <td><span class="fee-amount">$350</span> <small class="text-muted">/ term</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-bold">English for Business</div>
                                        <small class="text-muted">Corporate presentations & pitch practice</small>
                                    </td>
                                    <td>10 Weeks</td>
                                    <td><span class="fee-amount">$360</span> <small class="text-muted">/ term</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Financing details -->
                <div class="card border-0 bg-light-custom p-4 rounded-3">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle text-warning me-2"></i>Payment Policies</h5>
                    <ul class="mb-0 text-secondary" style="font-size:0.9rem; line-height:1.7;">
                        <li><strong>Installment Plans:</strong> Split payments into 2 halves (50% at enrollment, 50% at mid-term) are available with no interest fee.</li>
                        <li><strong>Rebranding Rebate:</strong> Get a 20% refund on tuition if you score 85%+ on our Placement Test.</li>
                        <li><strong>Withdrawal:</strong> 100% refund is issued if cancelled 3 days before course commencement. No refund after week 2.</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Key Dates / Timeline -->
            <div class="col-lg-5">
                <h3 class="fw-bold text-primary mb-4"><i class="far fa-calendar-alt me-2 text-warning"></i>Key Intake Calendar</h3>
                <p class="mb-4">Keep track of the enrollment intake, placement test weeks, orientation, and exam schedules.</p>
                
                <div class="timeline-container">
                    <div class="timeline-item completed">
                        <div class="timeline-date">June 1 - June 15, 2026</div>
                        <div class="timeline-content">
                            <h5>Admissions Open & Placement Weeks</h5>
                            <p>Register online and take the interactive Placement Test to secure your recommended program recommendation.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">June 20, 2026</div>
                        <div class="timeline-content">
                            <h5>Orientation & Manual Handouts</h5>
                            <p>Meet your lecturers, collect textbook handouts, and receive log-in details for the digital Student Portal.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-date">June 22, 2026</div>
                        <div class="timeline-content">
                            <h5>Classes Commence</h5>
                            <p>First official week of learning. Regular attendance sheets and self-study quiz deadlines are applied.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-date">August 3 - August 7, 2026</div>
                        <div class="timeline-content">
                            <h5>Mid-term Evaluation & Checkpoint</h5>
                            <p>Grammar and listening tests to check progression metrics. Advising sessions to guide struggling candidates.</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center pt-3">
                    <a href="{{ route('placement-test') }}" class="btn btn-primary btn-lg w-100 py-3 fw-bold" style="border-radius:12px;">
                        <i class="fas fa-clipboard-check me-2"></i> Register for Next Intake
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
