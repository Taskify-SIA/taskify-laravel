<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Activity;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::where('user_id', $user->id)->with('teamMembers');
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } else {
                $query->where('status', $request->status);
            }
        }
        
        $tasks = $query->orderBy('due_date', 'asc')->get();
        
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $this->authorize('update', $task);
        $task->load('teamMembers');
        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        $teamMembers = TeamMember::where('user_id', Auth::id())->get();
        return view('tasks.create', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:team_members,id'
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
            'due_time' => $validated['due_time'] ?? null,
        ]);

        if (isset($validated['team_members'])) {
            $task->teamMembers()->attach($validated['team_members']);
        }

        Activity::log(Auth::id(), 'task_created', "Tugas '{$task->title}' telah dibuat.");

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $teamMembers = TeamMember::where('user_id', Auth::id())->get();
        return view('tasks.edit', compact('task', 'teamMembers'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:team_members,id'
        ]);

        $task->update($validated);

        if (isset($validated['team_members'])) {
            $task->teamMembers()->sync($validated['team_members']);
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function toggleComplete(Task $task)
    {
        $this->authorize('update', $task);
        
        $task->is_completed = !$task->is_completed;
        if ($task->is_completed) {
            $task->status = 'completed';
            Activity::log(Auth::id(), 'task_completed', "Tugas '{$task->title}' selesai dikerjakan.");
        }
        $task->save();

        return back()->with('success', 'Status tugas berhasil diubah!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }
}