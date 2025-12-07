<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $teamMembers = TeamMember::where('user_id', Auth::id())->get();
        return view('team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:team_members,email',
            'role' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('avatar')) {
            // Create uploads directory if not exists
            $uploadPath = public_path('uploads/avatars');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Generate unique filename
            $filename = 'AVATAR_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            
            // Move file to public/uploads/avatars
            $request->file('avatar')->move($uploadPath, $filename);
            
            $validated['avatar'] = 'uploads/avatars/' . $filename;
        }

        TeamMember::create($validated);

        return redirect()->route('team.index')->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    public function edit(TeamMember $teamMember)
    {
        // Debug information
        Log::info('Team Member Edit Authorization Check', [
            'authenticated_user_id' => Auth::id(),
            'team_member_user_id' => $teamMember->user_id,
            'team_member_id' => $teamMember->id
        ]);
        
        $this->authorize('update', $teamMember);
        return view('team.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        // Debug information
        Log::info('Team Member Update Authorization Check', [
            'authenticated_user_id' => Auth::id(),
            'team_member_user_id' => $teamMember->user_id,
            'team_member_id' => $teamMember->id
        ]);
        
        $this->authorize('update', $teamMember);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:team_members,email,' . $teamMember->id,
            'role' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($teamMember->avatar && File::exists(public_path($teamMember->avatar))) {
                File::delete(public_path($teamMember->avatar));
            }

            // Create uploads directory if not exists
            $uploadPath = public_path('uploads/avatars');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Generate unique filename
            $filename = 'AVATAR_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            
            // Move file to public/uploads/avatars
            $request->file('avatar')->move($uploadPath, $filename);
            
            $validated['avatar'] = 'uploads/avatars/' . $filename;
        }

        $teamMember->update($validated);

        return redirect()->route('team.index')->with('success', 'Anggota tim berhasil diperbarui!');
    }

    public function destroy(TeamMember $teamMember)
    {
        // Debug information
        Log::info('Team Member Delete Authorization Check', [
            'authenticated_user_id' => Auth::id(),
            'team_member_user_id' => $teamMember->user_id,
            'team_member_id' => $teamMember->id
        ]);
        
        $this->authorize('delete', $teamMember);
        
        // Delete avatar if exists
        if ($teamMember->avatar && File::exists(public_path($teamMember->avatar))) {
            File::delete(public_path($teamMember->avatar));
        }
        
        $teamMember->delete();

        return redirect()->route('team.index')->with('success', 'Anggota tim berhasil dihapus!');
    }
}