<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\Expense;
use App\Models\PresentationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If user is admin, redirect to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $stats = $this->getDashboardStats($user);
        $teams = $this->getUserTeams($user); // Now includes latest report status
        $upcomingDeadlines = $this->getUpcomingDeadlines($user);
        $recentActivities = $this->getRecentActivities($user); // Corrected sorting and title usage
        $progressData = $this->getProgressData($user); // Corrected duplicate key

        return view('dashboard', compact(
            'stats',
            'teams',
            'upcomingDeadlines',
            'recentActivities',
            'progressData'
        ));
    }

    private function getDashboardStats($user)
    {
        // Use the relationship to get team IDs the user is a member of
        $teamIds = $user->teams()->pluck('teams.id'); // Assuming 'teams' is the relationship name in User model

        // If user can also own teams, include those IDs too
        // $ownedTeamIds = $user->ownedTeams()->pluck('id'); // Assuming 'ownedTeams' relationship exists
        // $allTeamIds = $teamIds->merge($ownedTeamIds)->unique();

        // Use $teamIds (or $allTeamIds if needed) for querying
        $allTeamIds = $teamIds; // Use only member teams for now, adjust if needed

        return [
            'active_teams' => $user->teams()->count(), // Count teams user is a member of
            'pending_approvals' => Proposal::whereIn('team_id', $allTeamIds)
                ->where('status', 'pending')
                ->count()
                + Report::whereIn('team_id', $allTeamIds) // Also count pending reports
                ->where('status', 'pending')
                ->count(),
            'upcoming_deadlines' => $this->getUpcomingDeadlinesCount($user),
            'total_budget' => $this->calculateTotalBudget($allTeamIds),
            'submitted_proposals' => Proposal::whereIn('team_id', $allTeamIds)
                // ->where('user_id', $user->id) // Removed: Counts ALL proposals in user's teams
                ->count(),
            'completed_reports' => Report::whereIn('team_id', $allTeamIds)
                ->where('status', 'approved')
                ->count(),
        ];
    }

    private function calculateTotalBudget($teamIds)
    {
        // Calculates sum based on Expense model columns: price, amount
        return Expense::whereIn('team_id', $teamIds)
            ->sum(DB::raw('price * amount')); // More efficient calculation
    }

    private function getUserTeams($user)
    {
        return $user->teams() // Assuming 'teams' is the membership relationship
            ->withCount(['members', 'proposals', 'reports', 'expenses'])
            ->with([
                'proposals' => function($query) { // Load only the latest proposal
                    $query->latest()->limit(1);
                },
                'reports' => function($query) { // Load only the latest report
                    $query->latest()->limit(1);
                },
                'presentationSchedule' // Load the presentation schedule if exists
            ])
            ->latest() // Order teams by creation date (latest first)
            ->get()
            ->map(function($team) {
                // Determine latest proposal status
                $latestProposal = $team->proposals->first();
                $team->latest_proposal_status = $latestProposal->status ?? 'not_submitted';
                $team->proposal_approved = $latestProposal && $latestProposal->status === 'approved'; // Flag for progress calc

                // Determine latest report status
                 $latestReport = $team->reports->first();
                 $team->latest_report_status = $latestReport->status ?? 'not_submitted';
                 $team->report_approved = $latestReport && $latestReport->status === 'approved'; // Flag for progress calc

                // Check if presentation is scheduled
                $team->has_presentation_scheduled = !is_null($team->presentationSchedule);

                // Calculate progress (passes the modified team object)
                $team->progress_percentage = $this->calculateTeamProgress($team);
                return $team;
            });
    }

    private function getUpcomingDeadlines($user)
    {
        $teamIds = $user->teams()->pluck('teams.id');
        $deadlines = collect();

        // Presentation schedules
        $presentationDeadlines = PresentationSchedule::whereIn('team_id', $teamIds)
            ->where('presentation_date', '>=', now()->toDateString())
            ->with('team') // Eager load team relationship
            ->get()
            ->map(function($schedule) {
                 // Check if team relationship is loaded correctly
                 if (!$schedule->team) {
                    return null; // Skip if team is missing (data integrity issue)
                 }
                // Combine date and time, handle potential null time
                $dateTimeString = $schedule->presentation_date . ' ' . ($schedule->presentation_time ?? '00:00:00');
                try {
                    $presentationDateTime = Carbon::parse($dateTimeString);
                    $daysRemaining = now()->diffInDays($presentationDateTime, false);

                    return [
                        'title' => 'Presentation: ' . $schedule->team->name,
                        'due_date' => $presentationDateTime,
                        'type' => 'presentation',
                        'icon' => 'calendar-alt', // Font Awesome icon name
                        'color' => 'purple', // For potential future use
                        'action_url' => route('presentation-schedules.index'), // Assumes route exists
                        'days_remaining' => $daysRemaining,
                        'urgent' => $daysRemaining >= 0 && $daysRemaining <= 3 // Urgent if 0-3 days left
                    ];
                } catch (\Exception $e) {
                    // Log error or handle invalid date/time format
                    report($e); // Log the exception
                    return null; // Skip this deadline
                }
            })->filter(); // Remove null entries

        // Pending Proposals (assuming a review deadline, e.g., 14 days after submission)
        $pendingProposals = Proposal::whereIn('team_id', $teamIds)
            ->where('status', 'pending') // Only show pending ones as deadlines
            ->where('created_at', '>=', now()->subDays(14)) // Only consider recent ones for deadline list
            ->with('team')
            ->get()
            ->map(function($proposal) {
                if (!$proposal->team) return null; // Skip if team missing
                $reviewDeadline = $proposal->created_at->addDays(14); // Example deadline
                $daysRemaining = now()->diffInDays($reviewDeadline, false);

                return [
                    'title' => 'Proposal Review Due: ' . $proposal->team->name,
                    'due_date' => $reviewDeadline,
                    'type' => 'proposal',
                    'icon' => 'file-alt',
                    'color' => 'blue',
                    'action_url' => route('teams.show', $proposal->team_id), // Link to team page
                    'days_remaining' => $daysRemaining,
                    'urgent' => $daysRemaining >= 0 && $daysRemaining <= 3
                ];
            })->filter();

         // Pending Reports (assuming a review deadline, e.g., 10 days after submission)
        $pendingReports = Report::whereIn('team_id', $teamIds)
            ->where('status', 'pending')
             ->where('created_at', '>=', now()->subDays(10)) // Only consider recent ones
            ->with('team')
            ->get()
            ->map(function($report) {
                 if (!$report->team) return null; // Skip if team missing
                $reviewDeadline = $report->created_at->addDays(10); // Example deadline
                $daysRemaining = now()->diffInDays($reviewDeadline, false);

                return [
                    'title' => 'Report Review Due: ' . $report->team->name,
                    'due_date' => $reviewDeadline,
                    'type' => 'report',
                    'icon' => 'clipboard-check',
                    'color' => 'green',
                    'action_url' => route('teams.show', $report->team_id), // Link to team page
                    'days_remaining' => $daysRemaining,
                    'urgent' => $daysRemaining >= 0 && $daysRemaining <= 3
                ];
            })->filter();


        return $deadlines->merge($presentationDeadlines)
            ->merge($pendingProposals)
            ->merge($pendingReports)
            ->filter(function($deadline) {
                return $deadline['days_remaining'] >= 0; // Filter out past deadlines definitively
            })
            ->sortBy('due_date') // Sort by the actual due date
            ->take(5); // Take the top 5 nearest deadlines
    }

    private function getUpcomingDeadlinesCount($user)
    {
        // Re-use the logic from getUpcomingDeadlines but just count
        // Note: This might be slightly inefficient as it queries multiple times.
        // Consider optimizing if performance becomes an issue.
        return $this->getUpcomingDeadlines($user)->count();
    }


    private function getRecentActivities($user)
    {
        $teamIds = $user->teams()->pluck('teams.id');
        $activities = collect();
        $limit = 8; // Total activities limit

        // Recent proposals
        $recentProposals = Proposal::whereIn('team_id', $teamIds)
            ->with(['user', 'team']) // Eager load user and team
            ->latest() // Order by creation date desc
            ->take($limit) // Limit query early
            ->get();

        foreach ($recentProposals as $proposal) {
             if (!$proposal->user || !$proposal->team) continue; // Skip if relationships failed
            $activities->push([
                'user' => $proposal->user->name,
                 // Corrected: Use file name or generic message instead of non-existent title
                'action' => "submitted proposal for {$proposal->team->name}",
                'timestamp' => $proposal->created_at, // Add timestamp for sorting
                'time' => $proposal->created_at->diffForHumans(),
                'team' => $proposal->team->name,
                'icon' => 'file-upload',
                'badge_color' => $this->getStatusBadgeColor($proposal->status),
                'status' => $proposal->status,
            ]);
        }

        // Recent reports
        $recentReports = Report::whereIn('team_id', $teamIds)
            ->with(['user', 'team'])
            ->latest()
            ->take($limit)
            ->get();

        foreach ($recentReports as $report) {
            if (!$report->user || !$report->team) continue;
            $activities->push([
                'user' => $report->user->name,
                // Corrected: Use file name or generic message
                'action' => "submitted report for {$report->team->name}",
                'timestamp' => $report->created_at, // Add timestamp for sorting
                'time' => $report->created_at->diffForHumans(),
                'team' => $report->team->name,
                'icon' => 'clipboard-check',
                'badge_color' => $this->getStatusBadgeColor($report->status),
                'status' => $report->status,
            ]);
        }

        // Recent expenses
        $recentExpenses = Expense::whereIn('team_id', $teamIds)
             ->with(['user', 'team']) // Expense model has user relationship
            ->latest()
            ->take($limit) // Take slightly fewer to allow for other types
            ->get();

        foreach ($recentExpenses as $expense) {
             if (!$expense->user || !$expense->team) continue;
            $activities->push([
                'user' => $expense->user->name,
                'action' => "added expense: {$expense->category} - RM " . number_format($expense->price * $expense->amount, 2),
                'timestamp' => $expense->created_at, // Add timestamp for sorting
                'time' => $expense->created_at->diffForHumans(),
                'team' => $expense->team->name,
                'icon' => 'money-bill-wave',
                 // Assuming expense status is boolean (true=approved)
                'badge_color' => $expense->status ? $this->getStatusBadgeColor('approved') : $this->getStatusBadgeColor('pending'),
                'status' => $expense->status ? 'approved' : 'pending',
            ]);
        }

         // Recent presentation schedules
        $recentSchedules = PresentationSchedule::whereIn('team_id', $teamIds)
            ->with('team')
            ->latest() // Order by creation date
            ->take($limit)
            ->get();

        foreach ($recentSchedules as $schedule) {
            if (!$schedule->team) continue;
            $formattedDate = Carbon::parse($schedule->presentation_date)->format('M d, Y');
            $activities->push([
                'user' => 'System', // Admin/System schedules this
                'action' => "scheduled presentation for {$schedule->team->name} on {$formattedDate}",
                'timestamp' => $schedule->created_at, // Add timestamp for sorting (using created_at)
                'time' => $schedule->created_at->diffForHumans(),
                'team' => $schedule->team->name,
                'icon' => 'calendar-alt',
                'badge_color' => $this->getStatusBadgeColor('scheduled'), // Custom status
                'status' => 'scheduled',
            ]);
        }


        // Corrected: Sort by actual timestamp DESC and take the final limit
        return $activities->sortByDesc('timestamp')->take($limit);
    }


    private function getProgressData($user)
    {
        // Get teams user is a member of
        $teams = $user->teams()->with(['proposals', 'reports', 'expenses', 'presentationSchedule'])->get();

        if ($teams->isEmpty()) {
            return [
                'team_formed' => false,
                'proposal_submitted' => false,
                'proposal_approved' => false,
                'presentation_scheduled' => false,
                'finance_planned' => false,
                'program_executed' => false,
                 // Corrected key: Should reflect report approval status
                'report_approved' => false,
            ];
        }

        // Determine the primary team (e.g., the one created most recently or with most activity)
        $primaryTeam = $teams->sortByDesc(function($team) {
            // Prioritize teams with more related records
             return optional($team->proposals)->count() + optional($team->reports)->count() + optional($team->expenses)->count();
        })->first() ?? $teams->first(); // Fallback to the first team if calculation fails


        // Check statuses based on the primary team
        return [
            'team_formed' => true, // If $teams is not empty, at least one team is formed
            'proposal_submitted' => $primaryTeam->proposals->isNotEmpty(),
            'proposal_approved' => $primaryTeam->proposals->where('status', 'approved')->isNotEmpty(),
            'presentation_scheduled' => !is_null($primaryTeam->presentationSchedule),
            'finance_planned' => $primaryTeam->expenses->isNotEmpty(),
            'program_executed' => $primaryTeam->reports->isNotEmpty(), // Assumes submitting a report means program was executed
             // Corrected key and check
            'report_approved' => $primaryTeam->reports->where('status', 'approved')->isNotEmpty(),
        ];
    }


    // Updated progress calculation based on flags set in getUserTeams
    private function calculateTeamProgress($team)
    {
        $steps = 7; // Total number of steps
        $completed = 0;

        // Step 1: Team formed (always true if we have the team object)
        $completed++;

        // Step 2: Proposal submitted
        if ($team->proposals_count > 0) $completed++;

        // Step 3: Proposal approved (using flag set in getUserTeams)
        if ($team->proposal_approved) $completed++;

        // Step 4: Presentation scheduled (using flag set in getUserTeams)
        if ($team->has_presentation_scheduled) $completed++;

        // Step 5: Finance planned (expenses added)
        if ($team->expenses_count > 0) $completed++;

        // Step 6: Program executed (report submitted)
        if ($team->reports_count > 0) $completed++;

        // Step 7: Final report approved (using flag set in getUserTeams)
        if ($team->report_approved) $completed++;


        return round(($completed / $steps) * 100);
    }


    private function getStatusBadgeColor($status)
    {
        // Map status strings to Tailwind CSS classes (adjust if using different CSS framework)
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'submitted' => 'bg-blue-100 text-blue-800', // For proposals/reports just submitted
            'scheduled' => 'bg-purple-100 text-purple-800', // For presentations
            'not_submitted' => 'bg-gray-100 text-gray-800',
        ];

        return $colors[strtolower($status)] ?? 'bg-gray-100 text-gray-800'; // Default gray
    }

    // --- Team Specific Dashboard Functions (Keep as is unless issues arise) ---

    public function teamDashboard(Team $team)
    {
        $user = Auth::user();

        // Ensure user is member or owner (adjust logic if needed)
        $isMember = $team->members()->where('user_id', $user->id)->exists();
        $isOwner = $team->user_id == $user->id; // Assuming user_id is the owner FK in teams table

        if (!$isMember && !$isOwner) {
            abort(403, 'You do not have permission to view this team dashboard.');
        }

        // Eager load necessary relationships
        $team->loadCount(['members', 'proposals', 'reports', 'expenses']);
        $team->load(['proposals' => function($q){ $q->latest(); },
                     'reports' => function($q){ $q->latest(); },
                     'expenses' => function($q){ $q->latest(); },
                     'presentationSchedule', 'members']); // Load members too

        $teamStats = [
            'total_members' => $team->members_count, // Use loaded count
            'total_proposals' => $team->proposals_count,
            'approved_proposals' => $team->proposals->where('status', 'approved')->count(), // Can refine if needed
            'total_reports' => $team->reports_count,
             'approved_reports' => $team->reports->where('status', 'approved')->count(),
            'total_expenses' => $team->expenses_count,
            'total_budget' => $team->expenses->sum(function($expense) {
                 return ($expense->price ?? 0) * ($expense->amount ?? 0);
            }),
            'has_presentation' => !is_null($team->presentationSchedule),
            'presentation_date' => optional($team->presentationSchedule)->presentation_date,
            'presentation_time' => optional($team->presentationSchedule)->presentation_time,
            'presentation_location' => optional($team->presentationSchedule)->location,
        ];

        $recentTeamActivities = $this->getTeamRecentActivities($team); // Corrected this function too

        return view('teams.dashboard', compact('team', 'teamStats', 'recentTeamActivities'));
    }


    // Corrected version for team-specific activities
    private function getTeamRecentActivities($team)
    {
        $activities = collect();
        $limit = 6; // Limit for team dashboard

        // Proposals
        $proposals = $team->proposals()->with('user')->latest()->take($limit)->get();
        foreach ($proposals as $proposal) {
            if (!$proposal->user) continue;
            $activities->push([
                'type' => 'proposal',
                'description' => "Proposal submitted by {$proposal->user->name}", // Generic description
                'user' => $proposal->user->name,
                'timestamp' => $proposal->created_at, // Timestamp for sorting
                'time' => $proposal->created_at->diffForHumans(),
                'icon' => 'file-upload',
                'status' => $proposal->status,
                'badge_color' => $this->getStatusBadgeColor($proposal->status),
            ]);
        }

        // Reports
        $reports = $team->reports()->with('user')->latest()->take($limit)->get();
        foreach ($reports as $report) {
             if (!$report->user) continue;
            $activities->push([
                'type' => 'report',
                'description' => "Report submitted by {$report->user->name}", // Generic description
                'user' => $report->user->name,
                'timestamp' => $report->created_at,
                'time' => $report->created_at->diffForHumans(),
                'icon' => 'clipboard-check',
                'status' => $report->status,
                'badge_color' => $this->getStatusBadgeColor($report->status),
            ]);
        }

        // Expenses
        $expenses = $team->expenses()->with('user')->latest()->take($limit)->get();
        foreach ($expenses as $expense) {
            if (!$expense->user) continue;
            $activities->push([
                'type' => 'expense',
                'description' => "Expense added: {$expense->category} - RM " . number_format($expense->price * $expense->amount, 2),
                'user' => $expense->user->name,
                'timestamp' => $expense->created_at,
                'time' => $expense->created_at->diffForHumans(),
                'icon' => 'money-bill-wave',
                'status' => $expense->status ? 'approved' : 'pending',
                'badge_color' => $expense->status ? $this->getStatusBadgeColor('approved') : $this->getStatusBadgeColor('pending'),
            ]);
        }

        // Presentation Schedule
        if ($team->presentationSchedule) {
            $activities->push([
                'type' => 'presentation',
                'description' => "Presentation scheduled for " . Carbon::parse($team->presentationSchedule->presentation_date)->format('M d, Y'),
                'user' => 'System',
                'timestamp' => $team->presentationSchedule->created_at, // Use created_at for sorting consistency
                'time' => $team->presentationSchedule->created_at->diffForHumans(),
                'icon' => 'calendar-alt',
                'status' => 'Scheduled',
                'badge_color' => $this->getStatusBadgeColor('scheduled'),
            ]);
        }

        // Sort by actual timestamp and take limit
        return $activities->sortByDesc('timestamp')->take($limit);
    }

}