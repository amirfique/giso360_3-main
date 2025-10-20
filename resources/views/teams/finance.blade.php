<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Finance Management - {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
                <!-- Expected Expenses -->
    <div class="mb-2">
        <div class="bg-white overflow-hidden border shadow-sm sm:rounded-lg">
            <div class="p-4 bg-white border-b border-gray-200">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Expected Expenses</h6>
                        <p class="text-sm">Total planned budget for GISO 2026 trip</p>
                    </div>
                    @if(auth()->id() === $team->owner_id)
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-dark" 
                                data-bs-toggle="modal" data-bs-target="#editBudgetModal">
                            <i class="fas fa-edit me-1"></i> Edit Budget
                        </button>
                    </div>
                    @endif
                </div>
                <div class="mt-4">
                    <h4 class="text-dark">RM {{ number_format($plannedBudget, 2) }}</h4>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm text-muted">Total Expenses:</span>
                            <span class="text-sm font-weight-semibold">RM {{ number_format($totalExpenses, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="text-sm text-muted">Remaining Budget:</span>
                            <span class="text-sm font-weight-semibold 
                                @if($plannedBudget - $totalExpenses < 0) text-danger 
                                @elseif($plannedBudget - $totalExpenses < ($plannedBudget * 0.2)) text-warning 
                                @else text-success @endif">
                                RM {{ number_format($plannedBudget - $totalExpenses, 2) }}
                            </span>
                        </div>
                        @if($plannedBudget > 0)
                        <div class="progress mt-2" style="height: 8px;">
                            @php
                                $percentage = min(100, ($totalExpenses / $plannedBudget) * 100);
                                $progressClass = $percentage > 90 ? 'bg-danger' : ($percentage > 70 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                style="width: {{ $percentage }}%" 
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="text-center mt-1">
                            <small class="text-muted">{{ number_format($percentage, 1) }}% of budget used</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Budget Modal -->
    @if(auth()->id() === $team->owner_id)
    <div class="modal fade" id="editBudgetModal" tabindex="-1" role="dialog" aria-labelledby="editBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBudgetModalLabel">Edit Planned Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('teams.updateBudget', $team) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="plannedBudget" class="form-label">Planned Budget (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="plannedBudget" 
                                name="planned_budget" value="{{ old('planned_budget', $plannedBudget) }}" 
                                min="0" required>
                            <div class="form-text">Set the total planned budget for GISO 2026 trip</div>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Current total expenses: RM {{ number_format($totalExpenses, 2) }}
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Update Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

            <!-- Expenses table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border border-gray-200">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg mb-0">Expenses</h6>
                                <p class="text-sm">Manage and track all expenses</p>
                            </div>
                            <div class="ms-auto d-flex">
                                <button type="button" class="btn btn-sm btn-white me-2">
                                    View all
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                    data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                    <span class="btn-inner--icon">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                            <path
                                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                        </svg>
                                    </span>
                                    <span class="btn-inner--text">Add Expenses</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-bottom py-3 d-sm-flex align-items-center">
                        <div class="input-group w-sm-25 ms-auto">
                            <span class="input-group-text text-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Search expenses">
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Expenses</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Price (RM)</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Amount</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Total (RM)</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Receipt</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Note</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center ms-1">
                                                <h6 class="mb-0 text-sm font-weight-semibold">{{ $expense->category }}</h6>
                                                <p class="text-sm text-secondary mb-0">Added by {{ $expense->user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">RM {{ number_format($expense->price, 2) }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">{{ $expense->amount }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">RM {{ number_format($expense->total, 2) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        @if($expense->receipt_file_path)
                                            <a href="{{ route('expenses.downloadReceipt', $expense) }}" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="tooltip" data-bs-title="Download receipt">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-sm text-secondary">No receipt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">{{ $expense->note ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('expenses.updateStatus', $expense) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" name="status" 
                                                    value="1" {{ $expense->status ? 'checked' : '' }} 
                                                    onchange="this.form.submit()"
                                                    {{ auth()->id() !== $team->owner_id ? 'disabled' : '' }}>
                                                <label class="form-check-label text-sm">
                                                    {{ $expense->status ? 'Approved' : 'Pending' }}
                                                </label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        @if(auth()->id() === $expense->user_id || auth()->id() === $team->owner_id)
                                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-xs" 
                                                        onclick="return confirm('Are you sure you want to delete this expense?')">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('expenses.store', $team) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="expenseCategory" class="form-label">Expense Category</label>
                            <input type="text" class="form-control" id="expenseCategory" name="category" 
                                   placeholder="e.g., Flight Ticket, Travel Insurance, Tour Guide" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expensePrice" class="form-label">Price (RM)</label>
                                    <input type="number" step="0.01" class="form-control" id="expensePrice" name="price" 
                                           placeholder="0.00" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expenseAmount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="expenseAmount" name="amount" 
                                           value="1" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="expenseNote" class="form-label">Note</label>
                            <textarea class="form-control" id="expenseNote" name="note" rows="3" 
                                      placeholder="Additional comments or details..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="expenseReceipt" class="form-label">Receipt (Optional)</label>
                            <input type="file" class="form-control" id="expenseReceipt" name="receipt">
                            <div class="form-text">Supported formats: PDF, JPG, PNG (Max: 5MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Add Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ session('success') }}');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ session('error') }}');
            });
        </script>
    @endif
</x-app-layout>