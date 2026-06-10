@extends('layouts.app')

@section('title', 'Front Web - About Us Management')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-1"><i class="fas fa-info-circle me-2"></i> About Us & Identity Management</h4>
            <p class="mb-0 text-white-50">Customize details like mission, vision, values statements, and organization history displayed on the website.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-edit me-2"></i> Edit Institution Statement</h5>
                </div>
                <div class="card-body">
                    <form onsubmit="event.preventDefault(); Swal.fire('Save Successful', 'Mock settings for About Us successfully saved!', 'success')">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">About Us (Introduction Text)</label>
                                <textarea class="form-control rounded-3" rows="5">LEARN Academy is Cambodia's premier English school, specializing in outcome-based academic preparation, interactive language courses, and student success support programs.</textarea>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">Our Mission Statement</label>
                                <textarea class="form-control rounded-3" rows="4">To deliver high-impact, communicative English training that equips students with real-world skills, enabling academic and professional growth globally.</textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">Our Vision Statement</label>
                                <textarea class="form-control rounded-3" rows="4">To be recognized as the regional gold standard in language learning, cultivating confident communicators who achieve excellence in their selected fields.</textarea>
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-hands-helping me-1"></i> Core Values</h6>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small text-muted">Value 1 (Title)</label>
                                <input type="text" class="form-control rounded-3 mb-2" value="Academic Excellence">
                                <textarea class="form-control rounded-3 small" rows="2">We push for high academic goals and prepare students with the practical capability to pass benchmarks.</textarea>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small text-muted">Value 2 (Title)</label>
                                <input type="text" class="form-control rounded-3 mb-2" value="Communicative Quality">
                                <textarea class="form-control rounded-3 small" rows="2">We construct our modules around modern interactive and speaking sessions for active confidence.</textarea>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small text-muted">Value 3 (Title)</label>
                                <input type="text" class="form-control rounded-3 mb-2" value="Outcome-Focused Support">
                                <textarea class="form-control rounded-3 small" rows="2">We offer language advisors, Peer Teaching mentors, and internships to solidify job readyness.</textarea>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold"><i class="fas fa-save me-2"></i> Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side Stats & Help Column -->
        <div class="col-12 col-lg-4">
            <!-- Live Preview Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-eye me-2"></i> Live Info Box</h5>
                </div>
                <div class="card-body">
                    <div class="border rounded-3 p-3 bg-light-subtle mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary rounded-pill"><i class="fas fa-school"></i></span>
                            <strong class="text-primary small">LEARN Academy</strong>
                        </div>
                        <p class="small text-muted mb-0">"Our mission is to deliver high-impact, communicative English training..."</p>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Last Updated By</span>
                        <strong class="text-dark">Admin Super</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Last Edited Date</span>
                        <strong class="text-dark">June 9, 2026</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2">
                        <span>Revision Version</span>
                        <strong class="text-dark">v1.4.2</strong>
                    </div>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="card border-0 shadow-sm rounded-4 bg-light border-start border-4 border-warning">
                <div class="card-body">
                    <h6 class="fw-bold text-warning mb-2"><i class="fas fa-lightbulb"></i> Optimization Tip</h6>
                    <p class="small text-muted mb-0">Keep these statements concise. A brief, impactful statement of 2-3 lines reads best on the website homepage and encourages higher visitor engagement.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
