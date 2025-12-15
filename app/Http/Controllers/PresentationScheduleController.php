<?php

namespace App\Http\Controllers;

use App\Models\PresentationSchedule;
use App\Models\Team;

class PresentationScheduleController extends Controller
{
    public function index()
    {
        // Get all teams for the current user
        $userTeams = auth()->user()->teams;
        
        // Get all presentation schedules
        $schedules = PresentationSchedule::with(['team', 'team.owner', 'team.members'])
            ->orderBy('presentation_date')
            ->orderBy('presentation_time')
            ->paginate(10);
        
        return view('presentation-schedules.index', compact('schedules'), [
            'teams' => $userTeams,
            'schedules' => $schedules
        ]);
    }
}