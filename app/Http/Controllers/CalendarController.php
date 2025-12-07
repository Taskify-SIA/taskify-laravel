<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);
        
        $currentDate = Carbon::createFromDate($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        // Get start of calendar (previous month's days if needed)
        $startOfCalendar = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfCalendar = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);
        
        // Generate calendar days
        $calendarDays = [];
        $currentDay = $startOfCalendar->copy();
        
        while ($currentDay <= $endOfCalendar) {
            $calendarDays[] = [
                'date' => $currentDay->copy(),
                'isCurrentMonth' => $currentDay->month == $month,
                'isToday' => $currentDay->isToday(),
                'dayNumber' => $currentDay->day
            ];
            $currentDay->addDay();
        }
        
        // Get tasks for this month
        $tasks = Task::where('user_id', Auth::id())
            ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function($task) {
                return Carbon::parse($task->due_date)->format('Y-m-d');
            });
        
        // Add tasks to calendar days
        foreach ($calendarDays as &$day) {
            $dateKey = $day['date']->format('Y-m-d');
            $day['tasks'] = $tasks->get($dateKey, collect());
            $day['hasTask'] = $day['tasks']->isNotEmpty();
        }
        
        return view('calendar.index', compact('calendarDays', 'currentDate'));
    }
}