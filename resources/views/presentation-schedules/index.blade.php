<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs">
                        <div class="card-body p-4">
                            <h1 class="h4 text-gradient text-primary mb-2">Presentation Schedules</h1>
                            <p class="text-sm mb-0">View all team presentation schedules</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search by Team Name or GISO ID..." id="searchInput">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presentation Schedules Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">All Presentation Schedules</h6>
                                    <p class="text-sm">View schedules for all GISO teams</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="schedulesTable">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">GISO Team ID</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Presentation Date</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Time</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Location</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedules as $schedule)
                                        <tr class="schedule-row">
                                            <td class="align-middle">
                                                <span class="text-sm font-weight-semibold">{{ $schedule->team->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-sm font-weight-semibold">{{ $schedule->team->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">
                                                    {{ $schedule->presentation_date->format('d F Y') }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">
                                                    {{ \Carbon\Carbon::parse($schedule->presentation_time)->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-sm">{{ $schedule->location }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-sm text-secondary">
                                                    {{ $schedule->notes ?? 'No notes' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            @if($schedules->hasPages())
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">
                                    Page {{ $schedules->currentPage() }} of {{ $schedules->lastPage() }}
                                </p>
                                <div class="ms-auto">
                                    @if($schedules->onFirstPage())
                                        <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                    @else
                                        <a href="{{ $schedules->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                    @endif
                                    
                                    @if($schedules->hasMorePages())
                                        <a href="{{ $schedules->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
                                    @else
                                        <button class="btn btn-sm btn-white mb-0" disabled>Next</button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Simple search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('.schedule-row');
                
                rows.forEach(row => {
                    const teamId = row.cells[0].textContent.toLowerCase();
                    const teamName = row.cells[1].textContent.toLowerCase();
                    
                    if (teamId.includes(searchTerm) || teamName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    </main>
</x-app-layout>