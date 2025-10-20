<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // Store a new report
    public function store(Request $request, Team $team)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,pptx,ppt,xlsx,xls|max:10240' // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('reports', $fileName, 'public');

            // Create report
            $report = Report::create([
                'title' => $request->title,
                'summary' => $request->summary,
                'file_path' => $filePath,
                'original_file_name' => $file->getClientOriginalName(),
                'user_id' => auth()->id(),
                'team_id' => $team->id,
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'Report submitted successfully!');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    // Download report file
    public function download(Report $report)
    {
        // Check if user has permission to download
        if (!auth()->user()->teams->contains($report->team_id)) {
            abort(403, 'Unauthorized action.');
        }

        $filePath = storage_path('app/public/' . $report->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $report->original_file_name);
    }

    // Update report status (for admin)
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        // Add authorization check here (only team owner/admin can update status)
        if (auth()->id() !== $report->team->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Report status updated successfully!');
    }

    // Delete report
    public function destroy(Report $report)
    {
        // Check if user is the owner of the report or team owner
        if (auth()->id() !== $report->user_id && auth()->id() !== $report->team->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file from storage
        Storage::disk('public')->delete($report->file_path);

        $report->delete();

        return redirect()->back()->with('success', 'Report deleted successfully!');
    }
}