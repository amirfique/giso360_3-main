<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Reports table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Report Review</h6>
                                    <p class="text-sm">Review and manage all submitted reports</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white me-2">
                                        Export
                                    </button>
                                    <div class="input-group input-group-sm ms-2 w-auto">
                                        <span class="input-group-text text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search reports">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">No.</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Report ID</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team ID</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date Sent</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Sender's Email</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">File</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $index => $report)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">{{ $index + 1 }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-sm font-weight-semibold">#{{ $report->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-sm">{{ $report->team->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-sm font-weight-semibold">{{ $report->team->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">
                                                    {{ $report->created_at->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-sm">{{ $report->user->email }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('reports.download', $report) }}" 
                                                   class="btn btn-sm btn-outline-dark mb-0"
                                                   target="_blank">
                                                    file.pdf
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" 
                                                            class="form-select status-select text-xs border-0 p-2 rounded" 
                                                            onchange="this.form.submit()"
                                                            style="
                                                                @if($report->status === 'approved') 
                                                                    background-color: #d1fae5; color: #065f46; 
                                                                @elseif($report->status === 'rejected') 
                                                                    background-color: #fee2e2; color: #991b1b;
                                                                @else 
                                                                    background-color: #f3f4f6; color: #6b7280;
                                                                @endif
                                                                font-weight: 600;">
                                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary mb-0"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#noteModal{{ $report->id }}">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M12 20h9"></path>
                                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                    </svg>
                                                    Note
                                                </button>

                                                <!-- Note Modal for each report -->
                                                <div class="modal fade" id="noteModal{{ $report->id }}" tabindex="-1" aria-labelledby="noteModalLabel{{ $report->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="noteModalLabel{{ $report->id }}">Add Note for Report #{{ $report->id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.reports.updateNote', $report) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="noteText{{ $report->id }}" class="form-label">Note for this report:</label>
                                                                        <textarea class="form-control" id="noteText{{ $report->id }}" name="note" rows="4" placeholder="Enter your notes or feedback for the team...">{{ $report->admin_note ?? '' }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-sm btn-dark">Save Note</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            @if($reports->hasPages())
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">
                                    Page {{ $reports->currentPage() }} of {{ $reports->lastPage() }}
                                </p>
                                <div class="ms-auto">
                                    @if($reports->onFirstPage())
                                        <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                    @else
                                        <a href="{{ $reports->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                    @endif
                                    
                                    @if($reports->hasMorePages())
                                        <a href="{{ $reports->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
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
    </main>
</x-app-layout>