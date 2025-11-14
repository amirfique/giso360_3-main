<x-app-layout>

    <div class="container-fluid py-4">
        
        <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs">
                        <div class="card-body p-4">
                            <h1 class="h4 text-gradient text-primary mb-2">Finance Management</h1>
                            <p class="text-sm mb-0">{{ $team->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

    
        <!-- Budget Overview Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-xs">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="card-title mb-1">Budget Overview</h5>
                                <p class="text-sm text-muted mb-0">Total planned budget for GISO 2026 trip</p>
                            </div>
                            @if(auth()->id() === $team->owner_id)
                            <button type="button" class="btn btn-sm btn-outline-primary mb-0" 
                                    data-bs-toggle="modal" data-bs-target="#editBudgetModal">
                                <i class="fas fa-edit me-2"></i> Edit Budget
                            </button>
                            @endif
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-4 col-md-4 mb-4 mb-md-0">
                                <div class="text-center p-3 border-radius-lg bg-gray-100">
                                    <h3 class="text-primary mb-1">RM {{ number_format($plannedBudget, 2) }}</h3>
                                    <p class="text-sm text-muted mb-0">Planned Budget</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-4 mb-md-0">
                                <div class="text-center p-3 border-radius-lg bg-gray-100">
                                    <h3 class="text-warning mb-1">RM {{ number_format($totalExpenses, 2) }}</h3>
                                    <p class="text-sm text-muted mb-0">Total Expenses</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="text-center p-3 border-radius-lg bg-gray-100">
                                    @php
                                        $remainingBudget = $plannedBudget - $totalExpenses;
                                        $remainingClass = $remainingBudget < 0 ? 'text-danger' : ($remainingBudget < ($plannedBudget * 0.2) ? 'text-warning' : 'text-success');
                                    @endphp
                                    <h3 class="{{ $remainingClass }} mb-1">RM {{ number_format($remainingBudget, 2) }}</h3>
                                    <p class="text-sm text-muted mb-0">Remaining Budget</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($plannedBudget > 0)
                        <div class="mt-4">
                            @php
                                $percentage = min(100, ($totalExpenses / $plannedBudget) * 100);
                                $progressClass = $percentage > 90 ? 'bg-gradient-danger' : ($percentage > 70 ? 'bg-gradient-warning' : 'bg-gradient-success');
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm text-muted">Budget Utilization</span>
                                <span class="text-sm font-weight-bold">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="progress" style="height: 12px; border-radius: 10px;">
                                <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                    style="width: {{ $percentage }}%; border-radius: 10px;" 
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-xs">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Expense Tracking</h6>
                                <p class="text-sm text-muted mb-0">Manage and track all expenses</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary mb-0">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <button type="button" class="btn btn-sm bg-gradient-primary mb-0"
                                    data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                    <i class="fas fa-plus me-1"></i> Add Expense
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body px-0 pt-0">
                        <!-- Search Bar -->
                        <div class="px-4 pt-3 pb-2">
                            <div class="input-group input-group-outline">
                                <span class="input-group-text text-body border-0 bg-gray-100">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-gray-100" placeholder="Search expenses...">
                            </div>
                        </div>

                        <!-- Expenses Table -->
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 ps-4">Expense</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center">Price</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center">Qty</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center">Total</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center">Receipt</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center">Status</th>
                                        <th class="text-secondary text-xs font-weight-bold opacity-7 text-center pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $expense)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape bg-gradient-primary shadow text-center rounded-circle me-3">
                                                    <i class="fas fa-receipt text-white text-xs"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm font-weight-bold">{{ $expense->category }}</h6>
                                                    <p class="text-xs text-muted mb-0">By {{ $expense->user->name }}</p>
                                                    @if($expense->note)
                                                    <p class="text-xs text-muted mb-0">{{ Str::limit($expense->note, 30) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-sm font-weight-bold">RM {{ number_format($expense->price, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-sm font-weight-bold">{{ $expense->amount }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-sm font-weight-bold text-dark">RM {{ number_format($expense->total, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($expense->receipt_file_path)
                                                <a href="{{ route('expenses.downloadReceipt', $expense) }}" 
                                                   class="btn btn-sm btn-outline-primary p-1"
                                                   data-bs-toggle="tooltip" title="Download Receipt">
                                                    <i class="fas fa-download text-sm"></i>
                                                </a>
                                            @else
                                                <span class="text-xs text-muted">No receipt</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('expenses.updateStatus', $expense) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                @if(auth()->id() === $team->owner_id)
                                                    <div class="form-check form-switch d-inline-block">
                                                        <input class="form-check-input" type="checkbox" name="status" 
                                                            value="1" {{ $expense->status ? 'checked' : '' }} 
                                                            onchange="this.form.submit()">
                                                        <label class="form-check-label text-sm">
                                                            {{ $expense->status ? 'Approved' : 'Pending' }}
                                                        </label>
                                                    </div>
                                                @else
                                                    <span class="badge badge-sm {{ $expense->status ? 'bg-gradient-success' : 'bg-gradient-warning' }}">
                                                        {{ $expense->status ? 'Approved' : 'Pending' }}
                                                    </span>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="text-center pe-4">
                                            @if(auth()->id() === $expense->user_id || auth()->id() === $team->owner_id)
                                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" 
                                                            onclick="return confirm('Are you sure you want to delete this expense?')"
                                                            data-bs-toggle="tooltip" title="Delete Expense">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    @if($expenses->count() === 0)
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="icon icon-shape bg-gradient-secondary shadow text-center rounded-circle mx-auto mb-3" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-receipt text-white text-lg"></i>
                                            </div>
                                            <h6 class="text-muted">No expenses recorded yet</h6>
                                            <p class="text-sm text-muted mb-3">Start by adding your first expense</p>
                                            <button type="button" class="btn btn-sm bg-gradient-primary mb-0"
                                                data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                                <i class="fas fa-plus me-1"></i> Add First Expense
                                            </button>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Budget Modal -->
    @if(auth()->id() === $team->owner_id)
    <div class="modal fade" id="editBudgetModal" tabindex="-1" role="dialog" aria-labelledby="editBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title mb-0" id="editBudgetModalLabel">Update Budget</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('teams.updateBudget', $team) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="plannedBudget" class="form-label fw-bold">Planned Budget (RM)</label>
                            <input type="number" step="0.01" class="form-control border-radius-lg" id="plannedBudget" 
                                name="planned_budget" value="{{ old('planned_budget', $plannedBudget) }}" 
                                min="0" required>
                            <div class="form-text">Set the total planned budget for GISO 2026 trip</div>
                        </div>
                        <div class="alert alert-info border-radius-lg">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                <div>
                                    <p class="mb-1 text-sm">Current total expenses: <strong>RM {{ number_format($totalExpenses, 2) }}</strong></p>
                                    <p class="mb-0 text-xs">Remaining budget after update: <strong>RM {{ number_format($plannedBudget - $totalExpenses, 2) }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-100 border-top">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-gradient-primary">Update Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title mb-0" id="addExpenseModalLabel">Add New Expense</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('expenses.store', $team) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="expenseCategory" class="form-label fw-bold">Expense Category</label>
                            <input type="text" class="form-control border-radius-lg" id="expenseCategory" name="category" 
                                   placeholder="e.g., Flight Ticket, Travel Insurance, Tour Guide" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expensePrice" class="form-label fw-bold">Price (RM)</label>
                                    <input type="number" step="0.01" class="form-control border-radius-lg" id="expensePrice" name="price" 
                                           placeholder="0.00" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expenseAmount" class="form-label fw-bold">Quantity</label>
                                    <input type="number" class="form-control border-radius-lg" id="expenseAmount" name="amount" 
                                           value="1" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="expenseNote" class="form-label fw-bold">Note (Optional)</label>
                            <textarea class="form-control border-radius-lg" id="expenseNote" name="note" rows="2" 
                                      placeholder="Additional comments or details..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="expenseReceipt" class="form-label fw-bold">Receipt (Optional)</label>
                            <input type="file" class="form-control border-radius-lg" id="expenseReceipt" name="receipt">
                            <div class="form-text">Supported formats: PDF, JPG, PNG (Max: 5MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-100 border-top">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-gradient-primary">Add Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    .card {
        border-radius: 0.75rem;
    }
    
    .border-radius-lg {
        border-radius: 0.75rem !important;
    }
    
    .shadow-xs {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(94, 114, 228, 0.02);
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa !important;
    }
    
    .input-group-outline .form-control {
        border: none;
        background: transparent;
    }
    
    .input-group-outline .form-control:focus {
        box-shadow: none;
        background: transparent;
    }
    </style>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // You can replace this with a toast notification for better UX
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