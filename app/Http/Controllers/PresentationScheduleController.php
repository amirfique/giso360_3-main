<?php

namespace App\Http\Controllers;

use App\Models\PresentationSchedule;
use App\Models\Team;
use Illuminate\Http\Request;

class PresentationScheduleController extends Controller
{
    // Show all presentation schedules (dedicated page)
    public function index()
    {
        $schedules = PresentationSchedule::with('team')
            ->orderBy('presentation_date')
            ->orderBy('presentation_time')
            ->paginate(10);

        return view('presentation-schedules.index', compact('schedules'));
    }

    // Show presentation schedule for a specific team (in team page)
    public function show(Team $team)
    {
        $schedule = $team->presentationSchedule;
        
        return view('teams.show', compact('team', 'schedule'));
    }
}