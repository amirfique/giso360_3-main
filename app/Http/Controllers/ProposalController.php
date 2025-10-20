<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    // Show all proposals for a team
    public function index(Team $team)
    {
        $proposals = $team->proposals()->with('user')->latest()->get();
        return view('teams.show', compact('team', 'proposals'));
    }

    // Store a new proposal
    public function store(Request $request, Team $team)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,pptx,ppt|max:10240' // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');

            // Create proposal
            $proposal = Proposal::create([
                'title' => $request->title,
                'summary' => $request->summary,
                'file_path' => $filePath,
                'original_file_name' => $file->getClientOriginalName(),
                'user_id' => auth()->id(),
                'team_id' => $team->id,
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'Proposal submitted successfully!');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    // Download proposal file
    public function download(Proposal $proposal)
    {
        // Check if user has permission to download
        if (!auth()->user()->teams->contains($proposal->team_id)) {
            abort(403, 'Unauthorized action.');
        }

        $filePath = storage_path('app/public/' . $proposal->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $proposal->original_file_name);
    }

    // Update proposal status (for admin)
    public function updateStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        // Add authorization check here (only team owner/admin can update status)
        if (auth()->id() !== $proposal->team->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $proposal->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Proposal status updated successfully!');
    }

    // Delete proposal
    public function destroy(Proposal $proposal)
    {
        // Check if user is the owner of the proposal or team owner
        if (auth()->id() !== $proposal->user_id && auth()->id() !== $proposal->team->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file from storage
        Storage::disk('public')->delete($proposal->file_path);

        $proposal->delete();

        return redirect()->back()->with('success', 'Proposal deleted successfully!');
    }
}