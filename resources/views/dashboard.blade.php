@extends('layouts.app')

@section('title', 'Dashboard - Student Management')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .dashboard-wrap {
        font-family: 'Open Sans', 'Battambang', sans-serif;
        background: #f0f2f8;
        min-height: 100vh;
        padding: 0 0 40px;
    }

    /* ── Hero Banner ── */
    .dash-hero {
        background: linear-gradient(135deg, #0d3f54 0%, #125875 100%);
        color: white;
        padding: 36px 36px 80px;
        position: relative;
        overflow: hidden;
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .dash-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30%;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .dash-hero h1 {
        font-size: 1.9rem;
        font-weight: 800;
        margin: 0 0 4px;
        letter-spacing: -0.5px;
    }
    .dash-hero p  { margin: 0; opacity: 0.75; font-size: 0.95rem; }
    .dash-hero .hero-actions { display: flex; gap: 10px; }
    .btn-hero {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 9px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-hero:hover {
        background: rgba(255,255,255,0.28);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* ── Stat Cards ── */
    .stats-row {
        padding: 0 24px;
        margin-top: -48px;
        position: relative;
        z-index: 10;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px 22px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        border-radius: 0 16px 0 80px;
        opacity: 0.08;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.14);
    }
    .stat-card .icon-wrap {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        color: white;
        margin-bottom: 16px;
        flex-shrink: 0;
    }
    .stat-card .stat-num {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
        letter-spacing: -1px;
    }
    .stat-card .stat-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card .stat-trend {
        font-size: 0.78rem;
        font-weight: 600;
        margin-top: 8px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 8px;
        border-radius: 20px;
    }

    /* Card accent colors */
    .sc-blue  .icon-wrap { background: linear-gradient(135deg,#125875,#1583b1); }
    .sc-blue  .stat-num  { color: #125875; }
    .sc-blue  .stat-trend { background:#e6f2f7; color:#125875; }
    .sc-blue::after       { background:#125875; }

    .sc-green .icon-wrap { background: linear-gradient(135deg,#01aa59,#10b981); }
    .sc-green .stat-num  { color: #01aa59; }
    .sc-green .stat-trend { background:#dcfce7; color:#01aa59; }
    .sc-green::after      { background:#01aa59; }

    .sc-purple .icon-wrap { background: linear-gradient(135deg,#0d3f54,#125875); }
    .sc-purple .stat-num  { color: #0d3f54; }
    .sc-purple .stat-trend { background:#e6f2f7; color:#0d3f54; }
    .sc-purple::after      { background:#0d3f54; }

    .sc-orange .icon-wrap { background: linear-gradient(135deg,#ff7350,#fca5a5); }
    .sc-orange .stat-num  { color: #ff7350; }
    .sc-orange .stat-trend { background:#ffedd5; color:#ff7350; }
    .sc-orange::after      { background:#ff7350; }

    .sc-rose .icon-wrap { background: linear-gradient(135deg,#ff7350,#e05e3c); }
    .sc-rose .stat-num  { color: #ff7350; }
    .sc-rose .stat-trend { background:#ffedd5; color:#ff7350; }
    .sc-rose::after      { background:#ff7350; }

    .sc-teal .icon-wrap { background: linear-gradient(135deg,#0891b2,#22d3ee); }
    .sc-teal .stat-num  { color: #0e7490; }
    .sc-teal .stat-trend { background:#cffafe; color:#0e7490; }
    .sc-teal::after      { background:#0891b2; }

    /* ── Section Headers ── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title i { color: var(--primary); }

    /* ── Chart Cards ── */
    .chart-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        border: none;
        padding: 24px;
        height: 100%;
    }
    .chart-card .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .chart-card .chart-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
    }
    .chart-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--primary-light);
        color: var(--primary);
    }

    /* ── Quick Actions ── */
    .quick-actions {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        padding: 24px;
    }
    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 10px;
        border: 1.5px solid #e2e8f0;
        color: #334155;
        font-weight: 600;
        font-size: 0.88rem;
    }
    .action-btn:last-child { margin-bottom: 0; }
    .action-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); transform: translateX(4px); }
    .action-btn .ab-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    /* ── Progress Bar ── */
    .progress-wrap { margin-bottom: 16px; }
    .progress-wrap:last-child { margin-bottom: 0; }
    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .progress {
        height: 8px;
        border-radius: 20px;
        background: #f1f5f9;
    }
    .progress-bar { border-radius: 20px; transition: width 1.5s cubic-bezier(.4,0,.2,1); }

    /* ── Activity Feed ── */
    .activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        padding: 24px;
    }
    .activity-empty {
        text-align: center;
        padding: 30px 0;
        color: #94a3b8;
    }
    .activity-empty i { font-size: 2.5rem; margin-bottom: 10px; display: block; }

    /* ── Counter animation ── */
    .counter { display: inline-block; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .dash-hero { padding: 24px 20px 64px; }
        .stats-row { padding: 0 12px; }
        .dash-hero h1 { font-size: 1.4rem; }
        .stat-card .stat-num { font-size: 1.7rem; }
    }
</style>

<div class="dashboard-wrap">

    {{-- ── Hero Banner ── --}}
    <div class="dash-hero">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h1><i class="fas fa-graduation-cap me-2"></i>Student Dashboard</h1>
                <p>Welcome back, <strong>{{ Auth::user()->name }}</strong> · {{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="hero-actions mt-1">
                <a href="{{ route('students.create') }}" class="btn-hero">
                    <i class="fas fa-plus"></i> Add Student
                </a>
                <a href="{{ route('students.export') }}" class="btn-hero">
                    <i class="fas fa-download"></i> Export CSV
                </a>
                <style>
        .stat-card-custom-blue {
            background: #1583b1;
            color: white;
            border-radius: 4px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            height: 100%;
            transition: transform 0.2s;
            border: none;
        }
        .stat-card-custom-blue:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }
        .stat-card-custom-green {
            background: #0fa180;
            color: white;
            border-radius: 4px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            height: 100%;
            transition: transform 0.2s;
            border: none;
        }
        .stat-card-custom-green:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }
        .icon-wrap-custom {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            position: absolute;
            right: 20px;
            bottom: 20px;
        }
        .num-custom {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-top: 8px;
            margin-bottom: 0;
        }
        .label-custom {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            text-transform: capitalize;
        }
    </style>

    {{-- ── Stat Cards (Matches Sample Screenshot) ── --}}
    <div class="stats-row">
        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-blue">
                    <div class="label-custom">Active Students</div>
                    <div class="num-custom counter" data-target="{{ $stats['active_students'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-graduation-cap"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-blue">
                    <div class="label-custom">Active Staffs</div>
                    <div class="num-custom counter" data-target="{{ $stats['active_staffs'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-blue">
                    <div class="label-custom">Total Classes</div>
                    <div class="num-custom counter" data-target="{{ $stats['total_classes'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-door-open"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-blue">
                    <div class="label-custom">Total Documents</div>
                    <div class="num-custom counter" data-target="{{ $stats['total_documents'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-file-alt"></i></div>
                </div>
            </div>
        </div>
        
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-green">
                    <div class="label-custom">Daily Phone Logs</div>
                    <div class="num-custom counter" data-target="{{ $stats['daily_phone_logs'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-phone"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-green">
                    <div class="label-custom">Daily Enquiries</div>
                    <div class="num-custom counter" data-target="{{ $stats['daily_enquiries'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-question-circle"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-green">
                    <div class="label-custom">Daily Postal Exchanges</div>
                    <div class="num-custom counter" data-target="{{ $stats['daily_postal_exchanges'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-exchange-alt"></i></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card-custom-green">
                    <div class="label-custom">System Audit Logs</div>
                    <div class="num-custom counter" data-target="{{ $stats['system_logs'] }}">0</div>
                    <div class="icon-wrap-custom"><i class="fas fa-history"></i></div>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

    {{-- ── Main Content ── --}}
    <div class="px-4 mt-4">
        <div class="row g-4">

            {{-- Charts Column --}}
            <div class="col-lg-8">
                <div class="row g-4">

                    {{-- Status Chart --}}
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="chart-header">
                                <span class="chart-title"><i class="fas fa-chart-bar text-primary me-2"></i>Student Status Overview</span>
                                <span class="chart-badge">Live Data</span>
                            </div>
                            <canvas id="statusChart" height="100"></canvas>
                        </div>
                    </div>

                    {{-- Grade Pie Chart --}}
                    <div class="col-md-6">
                        <div class="chart-card">
                            <div class="chart-header">
                                <span class="chart-title"><i class="fas fa-chart-pie text-purple me-2" style="color:#7c3aed"></i>By Grade</span>
                            </div>
                            @if($gradeStats->isNotEmpty())
                                <canvas id="gradeChart" height="220"></canvas>
                            @else
                                <div class="activity-empty">
                                    <i class="fas fa-chart-pie"></i>
                                    <p class="mb-0">No grade data yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Enrollment Progress --}}
                    <div class="col-md-6">
                        <div class="chart-card">
                            <div class="chart-header">
                                <span class="chart-title"><i class="fas fa-tasks text-success me-2"></i>Status Breakdown</span>
                            </div>
                            @php
                                $total = max($stats['total_students'], 1);
                                $activePct    = round($stats['active_students']    / $total * 100);
                                $inactivePct  = round($stats['inactive_students']  / $total * 100);
                                $graduatedPct = round($stats['graduated_students'] / $total * 100);
                            @endphp
                            <div class="pt-2">
                                <div class="progress-wrap">
                                    <div class="progress-label">
                                        <span><i class="fas fa-circle text-success me-1"></i>Active</span>
                                        <span>{{ $stats['active_students'] }} ({{ $activePct }}%)</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width:0%" data-width="{{ $activePct }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-wrap">
                                    <div class="progress-label">
                                        <span><i class="fas fa-circle text-danger me-1"></i>Inactive</span>
                                        <span>{{ $stats['inactive_students'] }} ({{ $inactivePct }}%)</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" style="width:0%" data-width="{{ $inactivePct }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-wrap">
                                    <div class="progress-label">
                                        <span><i class="fas fa-circle text-warning me-1" style="color:#ff7350 !important"></i>&nbsp;Graduated</span>
                                        <span>{{ $stats['graduated_students'] }} ({{ $graduatedPct }}%)</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width:0%;background:#ff7350" data-width="{{ $graduatedPct }}%"></div>
                                    </div>
                                </div>

                                {{-- Summary table --}}
                                <div class="mt-4 pt-3 border-top">
                                    <div class="row text-center g-2">
                                        <div class="col-4">
                                            <div style="font-size:1.4rem;font-weight:800;color:#01aa59">{{ $stats['active_students'] }}</div>
                                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase">Active</div>
                                        </div>
                                        <div class="col-4">
                                            <div style="font-size:1.4rem;font-weight:800;color:#ff7350">{{ $stats['inactive_students'] }}</div>
                                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase">Inactive</div>
                                        </div>
                                        <div class="col-4">
                                            <div style="font-size:1.4rem;font-weight:800;color:#0d3f54">{{ $stats['graduated_students'] }}</div>
                                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase">Graduated</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Trend Chart --}}
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="chart-header">
                                <span class="chart-title"><i class="fas fa-chart-line text-primary me-2"></i>Monthly Enrollment Trend</span>
                                <span class="chart-badge">Last 12 Months</span>
                            </div>
                            <canvas id="trendChart" height="80"></canvas>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">
                <div class="row g-4">

                    {{-- Quick Actions --}}
                    <div class="col-12">
                        <div class="quick-actions">
                            <div class="section-header mb-3">
                                <span class="section-title"><i class="fas fa-bolt"></i> Quick Actions</span>
                            </div>
                            <a href="{{ route('students.create') }}" class="action-btn">
                                <div class="ab-icon" style="background:var(--primary-light);color:var(--primary)"><i class="fas fa-user-plus"></i></div>
                                Add New Student
                            </a>
                            <a href="{{ route('students.index') }}" class="action-btn">
                                <div class="ab-icon" style="background:#dcfce7;color:#01aa59"><i class="fas fa-list"></i></div>
                                View All Students
                            </a>
                            <a href="{{ route('students.export') }}" class="action-btn">
                                <div class="ab-icon" style="background:#ffedd5;color:#ff7350"><i class="fas fa-file-csv"></i></div>
                                Export to CSV
                            </a>
                            <a href="{{ route('audit.index') }}" class="action-btn">
                                <div class="ab-icon" style="background:#fdf4ff;color:#9333ea"><i class="fas fa-history"></i></div>
                                View Audit Logs
                            </a>
                            <a href="{{ route('backup.index') }}" class="action-btn">
                                <div class="ab-icon" style="background:#e6f2f7;color:#125875"><i class="fas fa-database"></i></div>
                                Manage Backups
                            </a>
                        </div>
                    </div>

                    {{-- System Info --}}
                    <div class="col-12">
                        <div class="activity-card">
                            <div class="section-header mb-3">
                                <span class="section-title"><i class="fas fa-info-circle"></i> System Info</span>
                            </div>
                            <div style="font-size:0.85rem;">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted fw-500">Logged in as</span>
                                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Role</span>
                                    <span class="badge rounded-pill" style="background:var(--primary-light);color:var(--primary);font-size:0.78rem">
                                        {{ ucfirst(Auth::user()->role ?? 'staff') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Today</span>
                                    <span class="fw-600 text-dark">{{ now()->format('d M Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Total Records</span>
                                    <span class="fw-bold text-dark">{{ $stats['total_students'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">Documents</span>
                                    <span class="fw-bold text-dark">{{ $stats['total_documents'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Animated Counters ──
    document.querySelectorAll('.counter').forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        let current = 0;
        const step = Math.max(1, Math.ceil(target / 60));
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current.toLocaleString();
            if (current >= target) clearInterval(timer);
        }, 20);
    });

    // ── Animated Progress Bars ──
    setTimeout(() => {
        document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
            bar.style.width = bar.dataset.width;
        });
    }, 400);

    // ── Status Bar Chart ──
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Inactive', 'Graduated'],
            datasets: [{
                label: 'Students',
                data: [{{ $stats['active_students'] }}, {{ $stats['inactive_students'] }}, {{ $stats['graduated_students'] }}],
                backgroundColor: ['rgba(1,170,89,0.85)','rgba(255,115,80,0.85)','rgba(13,63,84,0.85)'],
                borderRadius: 10, borderSkipped: false, borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} students` } } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { weight: '600' } } },
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f1f5f9' } }
            },
            animation: { duration: 1200, easing: 'easeOutQuart' }
        }
    });

    // ── Grade Doughnut Chart ──
    @if($gradeStats->isNotEmpty())
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'doughnut',
        data: {
            labels: @json($gradeStats->pluck('grade')),
            datasets: [{ data: @json($gradeStats->pluck('count')),
                backgroundColor: ['#125875','#01aa59','#0d3f54','#ff7350','#0891b2','#e11d48','#4338ca','#64748b'],
                borderWidth: 3, borderColor: '#ffffff', hoverOffset: 8 }]
        },
        options: {
            responsive: true, cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { padding: 14, font: { size: 11, weight: '600' } } } },
            animation: { duration: 1200, easing: 'easeOutQuart' }
        }
    });
    @endif

    // ── Monthly Enrollment Trend ──
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json(collect($monthlyData)->pluck('month')),
                datasets: [{
                    label: 'New Students',
                    data: @json(collect($monthlyData)->pluck('count')),
                    borderColor: '#125875',
                    backgroundColor: 'rgba(18,88,117,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#125875',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} new students` } } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxTicksLimit: 6 } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f1f5f9' } }
                },
                animation: { duration: 1400, easing: 'easeOutQuart' }
            }
        });
    }
});
</script>

@endsection