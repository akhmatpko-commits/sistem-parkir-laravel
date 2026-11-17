<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query()
            ->latest('created_at');

        // Filter nama pengguna
        if ($request->filled('user_name')) {
            $query->where(
                'user_name',
                'like',
                '%' . $request->user_name . '%'
            );
        }

        // Filter role
        if ($request->filled('user_role')) {
            $query->where(
                'user_role',
                $request->user_role
            );
        }

        // Filter aktivitas
        if ($request->filled('activity')) {
            $query->where(
                'activity',
                'like',
                '%' . $request->activity . '%'
            );
        }

        // Filter tanggal mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_mulai
            );
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('activity_logs.index', compact('logs'));
    }
}
