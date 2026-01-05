<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Page Header - Keeping your original design -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background" style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white my-3">Presentation Schedules</h3>
                            <p class="mb-4 mt-2 font-weight-semibold">
                                View all presentation schedules for GISO teams
                            </p>
                            <img src="../assets/img/schedule-management 3d.png" alt="schedule image"
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presentation Schedules Table - Redesigned to match simple-card style -->
            <div class="row">
                <div class="col-12">
                    <div class="simple-card">
                        <div class="card-header-simple">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">All Presentation Schedules</h5>
                                        <p class="text-sm opacity-8 mb-0">View schedules for all GISO teams</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Search Bar moved here -->
                            <div class="search-container mt-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search by Team Name or GISO ID..." id="searchInput">
                                </div>
                            </div>
                        </div>
                        <div class="card-body-simple">
                            <div class="table-responsive">
                                <table class="simple-table">
                                    <thead>
                                        <tr>
                                            <th>GISO Team ID</th>
                                            <th>GISO Team Name</th>
                                            <th>Presentation Date</th>
                                            <th>Time</th>
                                            <th>Location</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="schedulesTableBody">
                                        @foreach($schedules as $schedule)
                                        <tr class="schedule-row">
                                            <td>
                                                <span class="team-id-badge">{{ $schedule->team->id }}</span>
                                            </td>
                                            <td>
                                                <div class="team-info">
                                                    <h6 class="team-name">{{ $schedule->team->name }}</h6>
                                                    <p class="team-type">{{ $schedule->team->type ?? 'Standard' }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="date-badge">
                                                    {{ $schedule->presentation_date->format('d F Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="time-badge">
                                                    {{ \Carbon\Carbon::parse($schedule->presentation_time)->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="location-text">{{ $schedule->location }}</span>
                                            </td>
                                            <td>
                                                <span class="notes-text">{{ $schedule->notes ?? 'No notes' }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($schedules->hasPages())
                            <div class="pagination-container d-flex justify-content-between align-items-center mt-4">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">
                                    Showing {{ $schedules->firstItem() }} to {{ $schedules->lastItem() }} of {{ $schedules->total() }} schedules
                                </p>
                                <div class="pagination-controls">
                                    @if($schedules->onFirstPage())
                                        <button class="btn-white-simple me-2" disabled>
                                            <i class="fas fa-chevron-left me-1"></i>
                                            Previous
                                        </button>
                                    @else
                                        <a href="{{ $schedules->previousPageUrl() }}" class="btn-white-simple me-2">
                                            <i class="fas fa-chevron-left me-1"></i>
                                            Previous
                                        </a>
                                    @endif
                                    
                                    @if($schedules->hasMorePages())
                                        <a href="{{ $schedules->nextPageUrl() }}" class="btn-white-simple">
                                            Next
                                            <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn-white-simple" disabled>
                                            Next
                                            <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

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

/* Schedule Specific Styles */
.schedule-row {
    transition: all 0.2s ease;
}

.schedule-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.team-id-badge {
    background: var(--primary);
    color: var(--white);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.team-info {
    display: flex;
    flex-direction: column;
}

.team-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.team-type {
    font-size: 0.85rem;
    color: var(--secondary);
    margin: 0;
}

.date-badge {
    background: rgba(100, 116, 139, 0.1);
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: var(--secondary);
    display: inline-block;
}

.time-badge {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    display: inline-block;
}

.location-text {
    font-size: 0.85rem;
    color: var(--dark);
}

.notes-text {
    font-size: 0.85rem;
    color: var(--secondary);
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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
    color: var(--dark);
}

/* Dropdown Menu Styles */
.dropdown-menu {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.dropdown-item {
    color: var(--dark);
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
    text-decoration: none;
}

.dropdown-item:hover {
    background: rgba(119, 77, 211, 0.05);
    color: var(--primary);
}

.dropdown-item.text-danger:hover {
    background: rgba(239, 68, 68, 0.05);
    color: var(--danger);
}

/* Search Container Styles */
.search-container {
    max-width: 100%;
}

/* Pagination Styles */
.pagination-controls {
    display: flex;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.schedule-row');
            
            rows.forEach(row => {
                const teamId = row.querySelector('.team-id-badge').textContent.toLowerCase();
                const teamName = row.querySelector('.team-name').textContent.toLowerCase();
                
                if (teamId.includes(searchTerm) || teamName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>