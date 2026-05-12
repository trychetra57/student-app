<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
        .student-info { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .action-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }
        .action-create { background: #28a745; }
        .action-update { background: #ffc107; color: #000; }
        .action-delete { background: #dc3545; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Management System</h1>
            <p>Student {{ ucfirst($action) }} Notification</p>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>A student record has been {{ $action == 'delete' ? 'deleted' : ($action == 'create' ? 'created' : 'updated') }} in the system.</p>

            @if($user)
                <p><strong>Action performed by:</strong> {{ $user->name }} ({{ $user->email }})</p>
            @endif

            <div class="student-info">
                <h3>Student Details</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Name:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Email:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Phone:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->phone ?: 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Grade:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->grade ?: 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Status:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                            <span class="action-badge action-{{ $student->status == 'active' ? 'create' : ($student->status == 'inactive' ? 'update' : 'delete') }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                    </tr>
                    @if($student->date_of_birth)
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Date of Birth:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->date_of_birth->format('M j, Y') }}</td>
                    </tr>
                    @endif
                    @if($student->address)
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Address:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->address }}</td>
                    </tr>
                    @endif
                    @if($student->guardian_name)
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Guardian:</strong></td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $student->guardian_name }}</td>
                    </tr>
                    @endif
                    @if($student->guardian_phone)
                    <tr>
                        <td style="padding: 8px 0;"><strong>Guardian Phone:</strong></td>
                        <td style="padding: 8px 0;">{{ $student->guardian_phone }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <p>This is an automated notification from the Student Management System.</p>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Student Management System. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>