<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->has('date_from') && $request->has('date_to')) {
            $dateFrom = \Carbon\Carbon::parse($request->date_from)->startOfDay();
            $dateTo = \Carbon\Carbon::parse($request->date_to)->endOfDay();
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where('description', 'like', "%{$keyword}%");
        }

        $logs = $query->paginate(10)->appends($request->query());
        return view('activity_logs.index', compact('logs'));
    }
}
