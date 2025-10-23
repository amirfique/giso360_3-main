<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams()->with('owner')->get();
        
        return view('teams.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => Auth::id(),
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'join_code' => strtoupper(Str::random(6)),
        ]);

        // Attach the owner to the team
        $team->members()->attach(Auth::id());

        return redirect()->route('teams.index')
            ->with('success', 'Team created successfully!');
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $team = Team::where('join_code', strtoupper($request->code))->first();

        if (!$team) {
            return redirect()->route('teams.index')
                ->with('error', 'Invalid join code.');
        }

        // Check if user is already a member
        if ($team->members()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('teams.index')
                ->with('error', 'You are already a member of this team.');
        }

        // Add user to team
        $team->members()->attach(Auth::id());

        return redirect()->route('teams.index')
            ->with('success', 'Successfully joined the team!');
    }

    public function show(Team $team)
    {
        // Check if user is a member of the team
        if (!$team->members()->where('user_id', Auth::id())->exists()) {
            abort(403, 'You are not a member of this team.');
        }

        // Load proposals and reports with their user relationships
        $proposals = $team->proposals()->with('user')->latest()->get();
        $reports = $team->reports()->with('user')->latest()->get();

        // Load the presentation schedule for this team
        $schedule = $team->presentationSchedule;

        return view('teams.show', compact('team', 'proposals', 'reports', 'schedule'));
    }
}