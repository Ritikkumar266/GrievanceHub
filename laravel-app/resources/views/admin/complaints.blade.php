@extends('layouts.app')

@section('title', 'Manage Complaints - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manage All Complaints</h1>
            <p class="text-gray-600 mt-2">View, assign, and manage complaints across all departments</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Department-wise Stats -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-chart-bar text-blue-600 mr-2"></i>Department-wise Complaint Statistics
            </h2>
        </div>
        <div class="p-6">
            @php
                // Get department stats manually for MongoDB compatibility
                $departmentStats = collect();
                foreach(App\Models\Department::all() as $dept) {
                    $dept->complaints_count = App\Models\Complaint::where('department_id', $dept->id)->count();
                    $dept->pending_count = App\Models\Complaint::where('department_id', $dept->id)->where('status', 'pending')->count();
                    $dept->in_progress_count = App\Models\Complaint::where('department_id', $dept->id)->where('status', 'in-progress')->count();
                    $dept->resolved_count = App\Models\Complaint::where('department_id', $dept->id)->where('status', 'resolved')->count();
                    $departmentStats->push($dept);
                }
            @endphp
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($departmentStats as $dept)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-3">{{ $dept->name }}</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-semibold text-blue-600">{{ $dept->complaints_count }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pending:</span>
                                <span class="font-semibold text-yellow-600">{{ $dept->pending_count }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">In Progress:</span>
                                <span class="font-semibold text-blue-600">{{ $dept->in_progress_count }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Resolved:</span>
                                <span class="font-semibold text-green-600">{{ $dept->resolved_count }}</span>
                            </div>
                            @if($dept->complaints_count > 0)
                                <div class="pt-2 border-t">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Resolution Rate:</span>
                                        <span class="font-semibold">
                                            {{ round(($dept->resolved_count / $dept->complaints_count) * 100, 1) }}%
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Department</label>
                <select name="department" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Departments</option>
                    @foreach(App\Models\Department::all() as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Priority</label>
                <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
            
            @if(request()->hasAny(['status', 'department', 'priority']))
                <div>
                    <a href="{{ route('admin.complaints') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Complaints List -->
    <div class="bg-white rounded-lg shadow">
        @if($complaints && $complaints->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    All Complaints ({{ $complaints->total() }} total)
                </h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($complaints as $complaint)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $complaint->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800
                                        @elseif($complaint->status == 'resolved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($complaint->priority == 'low') bg-gray-100 text-gray-800
                                        @elseif($complaint->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @elseif($complaint->priority == 'high') bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($complaint->priority) }} Priority
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-3">{{ Str::limit($complaint->description, 150) }}</p>
                                
                                <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div><i class="fas fa-tag mr-1"></i>Category: {{ $complaint->category }}</div>
                                        <div><i class="fas fa-calendar mr-1"></i>Submitted: {{ $complaint->created_at ? $complaint->created_at->format('M j, Y g:i A') : 'Unknown date' }}</div>
                                        @if($complaint->feedback)
                                            <div><i class="fas fa-star mr-1 text-yellow-500"></i>Rating: {{ $complaint->feedback->rating }}/5</div>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        @if($complaint->user)
                                            <div><i class="fas fa-user mr-1"></i>Citizen: {{ $complaint->user->name }}</div>
                                        @endif
                                        @if($complaint->department)
                                            <div><i class="fas fa-building mr-1"></i>Department: {{ $complaint->department->name }}</div>
                                        @else
                                            <div><i class="fas fa-exclamation-triangle mr-1 text-yellow-500"></i>Not Assigned</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('complaints.show', $complaint) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition text-center">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>
                                
                                @if(!$complaint->department_id)
                                    <button onclick="openAssignModal('{{ $complaint->id }}')" 
                                            class="bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700 transition">
                                        <i class="fas fa-hand-point-right mr-1"></i>Assign Dept
                                    </button>
                                @endif
                                
                                @if($complaint->status != 'resolved')
                                    <button onclick="openStatusModal('{{ $complaint->id }}', '{{ $complaint->status }}')" 
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                        <i class="fas fa-edit mr-1"></i>Update Status
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $complaints->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-inbox text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No complaints found</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['status', 'department', 'priority']))
                        No complaints match your current filters.
                    @else
                        No complaints have been submitted yet.
                    @endif
                </p>
                @if(request()->hasAny(['status', 'department', 'priority']))
                    <a href="{{ route('admin.complaints') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Assign Department Modal -->
<div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assign to Department</h3>
            
            <form id="assignForm" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="department_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Department</option>
                        @foreach(App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="closeAssignModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Assign Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Complaint Status</h3>
            
            <form id="statusForm" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="statusSelect" name="status" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending">Pending</option>
                            <option value="in-progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Admin Remarks</label>
                        <textarea name="remarks" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Add any remarks about this status change..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAssignModal(complaintId) {
    document.getElementById('assignModal').classList.remove('hidden');
    document.getElementById('assignForm').action = `/admin/complaints/${complaintId}/assign`;
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
}

function openStatusModal(complaintId, currentStatus) {
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('statusForm').action = `/admin/complaints/${complaintId}/status`;
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
</script>
@endsection