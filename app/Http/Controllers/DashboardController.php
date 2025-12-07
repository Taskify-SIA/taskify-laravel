<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Set timezone to Asia/Jakarta
        $now = Carbon::now()->timezone('Asia/Jakarta');
        
        $totalTasks = Task::where('user_id', $user->id)->count();
        $inProgressTasks = Task::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();
        $completedTasks = Task::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();
        
        // Recent tasks
        $recentTasks = Task::where('user_id', $user->id)
            ->orderBy('due_date', 'asc')
            ->limit(2)
            ->get();
        
        // Activities
        $activities = Activity::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Chart data - tasks completed per day for the last 7 days
        $chartData = [];
        $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $count = Task::where('user_id', $user->id)
                ->where('is_completed', true)
                ->whereDate('updated_at', $date)
                ->count();
            $chartData[] = $count;
        }
        
        return view('dashboard', compact(
            'totalTasks',
            'inProgressTasks',
            'completedTasks',
            'recentTasks',
            'activities',
            'chartData',
            'chartLabels'
        ));
    }
}