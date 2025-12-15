<x-app-layout>

        <div class="container-fluid py-4 px-5">
            <!-- Page Header - Keeping your original design -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <!-- Use absolute path for the background image -->
                        <div class="full-background" style="background-image: url('{{ asset('assets/img/header-blue-purple.jpg') }}')"></div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white my-3">Finance Management</h3>
                            <p class="mb-4 mt-2 font-weight-semibold">
                                Manage your team's budget and expenses efficiently.
                            </p>
                            <!-- Use absolute path for the image and update alt text -->
                             <img src="{{ asset('assets/img/finance-management 3d.png') }}" alt="finance management image"
                            class="position-absolute top-0 end-0 w-25 max-width-200 mt-n4 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Overview Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="simple-card">
                        <div class="card-header-simple">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Budget Overview</h5>
                                        <p class="text-sm opacity-8 mb-0">Total planned budget for GISO 2026 trip</p>
                                    </div>
                                </div>
                                @if(auth()->id() === $team->owner_id)
                                <div class="d-flex">
                                    <button type="button" class="btn-white-simple" 
                                            data-bs-toggle="modal" data-bs-target="#editBudgetModal">
                                        <i class="fas fa-edit me-2"></i> Edit Budget
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body-simple">
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
                    <div class="simple-card">
                        <div class="card-header-simple">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Expense Tracking</h5>
                                        <p class="text-sm opacity-8 mb-0">Manage and track all expenses</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="button" class="btn-white-simple me-2">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                    <button type="button" class="btn-primary-simple"
                                        data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                        <i class="fas fa-plus me-2"></i> Add Expense
                                    </button>
                                </div>
                            </div>
                            <!-- Search Bar moved here -->
                            <div class="search-container mt-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search expenses..." id="searchInput">
                                </div>
                            </div>
                        </div>
                        <div class="card-body-simple">
                            <div class="table-responsive">
                                <table class="simple-table">
                                    <thead>
                                        <tr>
                                            <th>Expense</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expenses as $expense)
                                        <tr class="expense-row">
                                            <td>
                                                <div class="expense-info">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon icon-shape bg-gradient-primary shadow text-center rounded-circle me-3">
                                                            <i class="fas fa-receipt text-white text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="expense-category">{{ $expense->category }}</h6>
                                                            <p class="expense-user">By {{ $expense->user->name }}</p>
                                                            @if($expense->note)
                                                            <p class="expense-note">{{ Str::limit($expense->note, 30) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="price-badge">RM {{ number_format($expense->price, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="qty-badge">{{ $expense->amount }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="total-badge">RM {{ number_format($expense->total, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($expense->receipt_file_path)
                                                    <a href="{{ route('expenses.downloadReceipt', $expense) }}" 
                                                       class="btn btn-sm btn-outline-primary p-1"
                                                       data-bs-toggle="tooltip" title="Download Receipt">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </a>
                                                @else
                                                    <span class="no-receipt">No receipt</span>
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
                                                        <span class="status-badge {{ $expense->status ? 'approved' : 'pending' }}">
                                                            {{ $expense->status ? 'Approved' : 'Pending' }}
                                                        </span>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                @if(auth()->id() === $expense->user_id || auth()->id() === $team->owner_id)
                                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action" 
                                                                onclick="return confirm('Are you sure you want to delete this expense?')"
                                                                data-bs-toggle="tooltip" title="Delete Expense">
                                                            <i class="fas fa-trash"></i>
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
                                                <button type="button" class="btn-primary-simple"
                                                    data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                                    <i class="fas fa-plus me-2"></i> Add First Expense
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
                        <button type="button" class="btn-white-simple" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-simple">Update Budget</button>
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
                        <button type="button" class="btn-white-simple" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-simple">Add Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    /* Color Variables */
    :root {
        --primary: #774dd3;
        --secondary: #64748b;
        --white: #FFFFFF;
        --dark: #1E293B;
        --light-bg: rgba(255, 255, 255, 0.8);
        --border-color: rgba(100, 116, 139, 0.5);
        --border-dark: rgba(30, 41, 59, 0.6);
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
    }

    /* Simple Card Styles */
    .simple-card {
        background: var(--light-bg);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 2px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        height: 100%;
        transition: transform 0.2s ease;
    }

    .card-header-simple {
        background: linear-gradient(135deg, rgba(73, 0, 230, 0.1) 0%, rgba(73, 0, 230, 0.1) 100%);
        padding: 1.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .card-header-simple p {
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .card-body-simple {
        padding: 1.5rem;
    }

    /* Button Styles */
    .btn-primary-simple {
        background: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: var(--white);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary-simple:hover {
        background: #6439b3;
        border-color: #6439b3;
        color: var(--white);
    }

    .btn-white-simple {
        background: var(--white);
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: var(--dark);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-white-simple:hover:not(:disabled) {
        background: #f8fafc;
        border-color: var(--border-dark);
    }

    .btn-white-simple:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Form Styles */
    .form-control {
        background: var(--white);
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        color: var(--dark);
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(119, 77, 211, 0.1);
        outline: none;
    }

    .input-group-text {
        background: var(--white);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--primary);
    }

    /* Table Styles */
    .simple-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .simple-table th {
        background: rgba(119, 77, 211, 0.05);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
        border-bottom: 2px solid var(--border-color);
    }

    .simple-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .simple-table tr:last-child td {
        border-bottom: none;
    }

    .simple-table tr:hover td {
        background: rgba(119, 77, 211, 0.03);
    }

    /* Expense Specific Styles */
    .expense-row {
        transition: all 0.2s ease;
    }

    .expense-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .expense-category {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .expense-user {
        font-size: 0.85rem;
        color: var(--secondary);
        margin: 0;
    }

    .expense-note {
        font-size: 0.85rem;
        color: var(--secondary);
        margin: 0;
    }

    .price-badge, .qty-badge, .total-badge {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark);
    }

    .no-receipt {
        font-size: 0.85rem;
        color: var(--secondary);
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.approved {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    /* Action Button Styles */
    .btn-action {
        background: transparent;
        border: none;
        color: var(--secondary);
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        background: rgba(100, 116, 139, 0.1);
        color: var(--danger);
    }

    /* Search Container Styles */
    .search-container {
        max-width: 100%;
    }

    /* Additional Styles */
    .bg-gray-100 {
        background-color: #f8f9fa !important;
    }

    .border-radius-lg {
        border-radius: 0.75rem !important;
    }

    .progress {
        background-color: #e9ecef;
    }

    .icon-shape {
        width: 2.5rem;
        height: 2.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    </style>

    <style>
    .card-background {
        position: relative;
        overflow: hidden;
    }
    
    .full-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
    }
    
    .card-background .card-body {
        position: relative;
        z-index: 1;
    }
    
    .card-background-after-none::after {
        display: none;
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.expense-row');
                
                rows.forEach(row => {
                    const category = row.querySelector('.expense-category').textContent.toLowerCase();
                    const user = row.querySelector('.expense-user').textContent.toLowerCase();
                    const note = row.querySelector('.expense-note');
                    const noteText = note ? note.textContent.toLowerCase() : '';
                    
                    if (category.includes(searchTerm) || user.includes(searchTerm) || noteText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
    </script>
</x-app-layout>