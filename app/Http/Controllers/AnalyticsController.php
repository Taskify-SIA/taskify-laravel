<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', '7d'); // 7d, 30d, 3m

        switch ($range) {
            case '30d':
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                $label = '30 Hari Terakhir';
                break;
            case '3m':
                $startDate = Carbon::now()->subMonths(3)->startOfDay();
                $label = '3 Bulan Terakhir';
                break;
            case '7d':
            default:
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                $label = '7 Hari Terakhir';
                $range = '7d';
                break;
        }

        $endDate = Carbon::now()->endOfDay();

        // Base query for tasks in selected range
        $tasksQuery = Task::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalTasks = (clone $tasksQuery)->count();
        $completedTasks = (clone $tasksQuery)->where('is_completed', true)->count();
        $inProgressTasks = (clone $tasksQuery)->where('status', 'in_progress')->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Priority distribution in range
        $highPriority = (clone $tasksQuery)->where('priority', 'high')->count();
        $mediumPriority = (clone $tasksQuery)->where('priority', 'medium')->count();
        $lowPriority = (clone $tasksQuery)->where('priority', 'low')->count();

        // Daily completion data for chart (use updated_at as completion timestamp)
        $dailyData = (clone $tasksQuery)
            ->where('is_completed', true)
            ->selectRaw('DATE(updated_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $period = new \DatePeriod(
            $startDate->copy()->startOfDay(),
            new \DateInterval('P1D'),
            $endDate->copy()->addDay()->startOfDay()
        );

        $labels = [];
        $completionData = [];

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $labels[] = $date->format('d M');
            $completionData[] = $dailyData[$key] ?? 0;
        }

        // Team performance within range (tasks created in range)
        $teamMembers = $user->teamMembers()
            ->withCount(['tasks' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tasks.created_at', [$startDate, $endDate]);
            }])
            ->get();

        return view('analytics.index', compact(
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'completionRate',
            'highPriority',
            'mediumPriority',
            'lowPriority',
            'labels',
            'completionData',
            'teamMembers',
            'range',
            'label',
            'startDate',
            'endDate'
        ));
    }
}


