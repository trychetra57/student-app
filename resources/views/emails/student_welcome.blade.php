<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:'Segoe UI',sans-serif;background:#f0f2f8;margin:0;padding:40px 20px;}
        .card{max-width:560px;margin:0 auto;background:white;border-radius:20px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.1);}
        .header{background:linear-gradient(135deg,#1e3a8a,#2563eb);padding:40px 40px 32px;text-align:center;}
        .header i{font-size:2.5rem;color:rgba(255,255,255,.9);margin-bottom:12px;display:block;}
        .header h1{color:white;margin:0;font-size:1.6rem;font-weight:800;}
        .header p{color:rgba(255,255,255,.7);margin:8px 0 0;font-size:.95rem;}
        .body{padding:36px 40px;}
        .greeting{font-size:1.15rem;font-weight:700;color:#1e293b;margin-bottom:8px;}
        .text{color:#475569;line-height:1.7;margin-bottom:20px;}
        .info-box{background:#f8fafc;border-radius:12px;padding:20px;margin:24px 0;}
        .info-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;font-size:.88rem;}
        .info-row:last-child{border-bottom:none;}
        .info-label{color:#94a3b8;font-weight:600;}
        .info-value{color:#1e293b;font-weight:600;}
        .badge{display:inline-block;padding:3px 12px;border-radius:20px;font-size:.78rem;font-weight:600;background:#dcfce7;color:#15803d;}
        .footer{background:#f8fafc;padding:24px 40px;text-align:center;color:#94a3b8;font-size:.8rem;}
        .footer strong{color:#475569;}
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <i>🎓</i>
        <h1>Welcome to BelTei University!</h1>
        <p>Student Registration Confirmed</p>
    </div>
    <div class="body">
        <div class="greeting">Hello, {{ $student->name }}!</div>
        <p class="text">
            You have been successfully registered in our student management system.
            Below are your enrollment details. Please keep this information safe.
        </p>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Student ID</span>
                <span class="info-value">#{{ $student->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $student->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $student->email }}</span>
            </div>
            @if($student->grade)
            <div class="info-row">
                <span class="info-label">Grade / Class</span>
                <span class="info-value">{{ $student->grade }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value"><span class="badge">{{ ucfirst($student->status) }}</span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Enrolled On</span>
                <span class="info-value">{{ $student->created_at->format('M j, Y') }}</span>
            </div>
        </div>
        <p class="text">
            If you have any questions or need assistance, please contact the school administration team.
        </p>
    </div>
    <div class="footer">
        <strong>BelTei University Admin</strong><br>
        &copy; {{ date('Y') }} Student Management System. All rights reserved.
    </div>
</div>
</body>
</html>
