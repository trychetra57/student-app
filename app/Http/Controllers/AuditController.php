<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Filter by user
        if ($request->has('user') && !empty($request->user)) {
            $query->where('user_id', $request->user);
        }

        // Filter by action
        if ($request->has('action') && !empty($request->action)) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->paginate(25)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('audit.index', compact('auditLogs', 'users'));
    }
}