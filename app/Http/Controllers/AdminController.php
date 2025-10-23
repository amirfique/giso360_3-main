<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\PresentationSchedule;

class AdminController extends Controller
{
    public function __construct()
    {
        // Apply admin middleware to all methods in this controller
        $this->middleware('admin');
    }

    // Admin Dashboard
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_teams' => Team::count(),
            'total_proposals' => Proposal::count(),
            'total_reports' => Report::count(),
            'pending_proposals' => Proposal::where('status', 'pending')->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        // Recent activities
        $recentProposals = Proposal::with(['user', 'team'])
            ->latest()
            ->take(5)
            ->get();

        $recentReports = Report::with(['user', 'team'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProposals', 'recentReports'));
    }

    // User Management
    public function users()
    {
        $users = User::withCount(['teams', 'proposals', 'reports'])
            ->latest()
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    // Teams Management
    public function teams()
    {
        $teams = Team::withCount(['members', 'proposals', 'reports', 'expenses'])
            ->with('owner')
            ->latest()
            ->paginate(10);

        return view('admin.teams', compact('teams'));
    }

    // Proposals Management
    public function proposals()
    {
        $proposals = Proposal::with(['user', 'team'])
            ->latest()
            ->paginate(10);

        return view('admin.proposals', compact('proposals'));
    }

    // Update Proposal Status
    public function updateProposalStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $proposal->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Proposal status updated successfully!');
    }

    // Update Proposal Note
     public function updateProposalNote(Request $request, Proposal $proposal)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000'
        ]);

        $proposal->update(['admin_note' => $request->note]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }

    // Reports Management
    public function reports()
    {
        $reports = Report::with(['user', 'team'])
            ->latest()
            ->paginate(10);

        return view('admin.reports', compact('reports'));
    }

    // Update Report Status
    public function updateReportStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Report status updated successfully!');
    }

    // Expenses Management
    public function expenses()
    {
        $expenses = Expense::with(['user', 'team'])
            ->latest()
            ->paginate(10);

        return view('admin.expenses', compact('expenses'));
    }

    // Update Report Note
    public function updateReportNote(Request $request, Report $report)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000'
        ]);

        $report->update(['admin_note' => $request->note]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }


    // Update User Role
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,student'
        ]);

        // Prevent admin from changing their own role
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    // Delete User
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    // Presentation Schedule Management
    public function presentationSchedules(Request $request)
    {
        $query = Team::with(['presentationSchedule', 'proposals']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter by proposal status
        if ($request->has('proposal_status') && $request->proposal_status != '') {
            $query->whereHas('proposals', function($q) use ($request) {
                $q->where('status', $request->proposal_status);
            });
        }

        // Ordering
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'name':
                    $query->orderBy('name');
                    break;
                case 'id':
                    $query->orderBy('id');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $teams = $query->paginate(10);

        return view('admin.presentation-schedules', compact('teams'));
    }

    // Update Presentation Schedule
    public function updatePresentationSchedule(Request $request, Team $team)
    {
        $request->validate([
            'presentation_date' => 'required|date',
            'presentation_time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Update or create presentation schedule
        $team->presentationSchedule()->updateOrCreate(
            ['team_id' => $team->id],
            [
                'presentation_date' => $request->presentation_date,
                'presentation_time' => $request->presentation_time,
                'location' => $request->location,
                'notes' => $request->notes
            ]
        );

        return redirect()->back()->with('success', 'Presentation schedule updated successfully!');
    }
}