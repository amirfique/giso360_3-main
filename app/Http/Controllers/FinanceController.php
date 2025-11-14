<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinanceController extends Controller
{
    // Show finance page for a team
    public function show(Team $team)
    {   

        // Check if user is a member of the team
        if (!$team->members()->where('user_id', auth()->id())->exists()) {
            abort(403, 'You are not a member of this team.');
        }

        $expenses = $team->expenses()->with('user')->latest()->get();
        $totalExpenses = $team->expenses()->sum('total');
        $plannedBudget = $team->planned_budget;
        
        return view('teams.finance', compact('team', 'expenses', 'totalExpenses', 'plannedBudget'));
    }

    // Update planned budget
    public function updateBudget(Request $request, Team $team)
    {
        // Only team owner can update budget
        if (auth()->id() !== $team->owner_id) {
            abort(403, 'Only team owner can update budget.');
        }

        $request->validate([
            'planned_budget' => 'required|numeric|min:0'
        ]);

        $team->update([
            'planned_budget' => $request->planned_budget
        ]);

        return redirect()->back()->with('success', 'Budget updated successfully!');
    }

    // Store a new expense
    public function store(Request $request, Team $team)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // 5MB max
        ]);

        // Handle file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $receiptPath = $file->storeAs('receipts', $fileName, 'public');
        }

        // Calculate total
        $total = $request->price * $request->amount;

        // Create expense
        Expense::create([
            'category' => $request->category,
            'price' => $request->price,
            'amount' => $request->amount,
            'total' => $total,
            'receipt_file_path' => $receiptPath,
            'note' => $request->note,
            'user_id' => auth()->id(),
            'team_id' => $team->id,
            'status' => false // Default to pending
        ]);

        return redirect()->route('teams.finance', $team)->with('success', 'Expense added successfully!');
    }

    // Download receipt file
    public function downloadReceipt(Expense $expense)
    {
        // Check if user has permission to download
        if (!auth()->user()->teams->contains($expense->team_id)) {
            abort(403, 'Unauthorized action.');
        }

        if (!$expense->receipt_file_path) {
            abort(404, 'No receipt found.');
        }

        $filePath = storage_path('app/public/' . $expense->receipt_file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, 'receipt_' . $expense->category . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    // Update expense status (approve/reject)
    public function updateStatus(Request $request, Expense $expense)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        // Only team owner can update status
        if (auth()->id() !== $expense->team->owner_id) {
            abort(403, 'Only team owner can update expense status.');
        }

        $expense->update(['status' => $request->status]);

        $statusText = $request->status ? 'approved' : 'rejected';
        return redirect()->back()->with('success', "Expense {$statusText} successfully!");
    }

    // Delete expense
    public function destroy(Expense $expense)
    {
        // Check if user is the owner of the expense or team owner
        if (auth()->id() !== $expense->user_id && auth()->id() !== $expense->team->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file from storage if exists
        if ($expense->receipt_file_path) {
            Storage::disk('public')->delete($expense->receipt_file_path);
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Expense deleted successfully!');
    }
}