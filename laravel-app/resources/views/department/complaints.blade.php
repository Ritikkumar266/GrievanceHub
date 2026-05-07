@extends('layouts.app')

@section('title', 'Department Complaints - ComplaintHub')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Department Complaints</h1>
            <p class="text-gray-600 mt-2">
                Manage complaints assigned to 
                @if(Auth::user()->department)
                    {{ Auth::user()->department->name }}
                @else
                    your department
                @endif
            </p>
        </div>
        <a href="{{ route('department.dashboard') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-clipboard-list text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-semibold">{{ $complaints ? $complaints->count() : 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold">{{ $complaints ? $complaints->where('status', 'pending')->count() : 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-cog text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">In Progress</p>
                    <p class="text-2xl font-semibold">{{ $complaints ? $complaints->where('status', 'in-progress')->count() : 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Resolved</p>
                    <p class="text-2xl font-semibold">{{ $complaints ? $complaints->where('status', 'resolved')->count() : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="bg-white rounded-lg shadow">
        @if($complaints && $complaints->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Assigned Complaints</h2>
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
                                
                                <p class="text-gray-600 mb-2">{{ Str::limit($complaint->description, 150) }}</p>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-tag mr-1"></i>{{ $complaint->category }}</span>
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $complaint->created_at ? $complaint->created_at->format('M j, Y') : 'Unknown date' }}</span>
                                    @if($complaint->user)
                                        <span><i class="fas fa-user mr-1"></i>{{ $complaint->user->name }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('department.show', $complaint) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition text-center">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>
                                
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
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-inbox text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No complaints assigned</h3>
                <p class="text-gray-600 mb-6">No complaints have been assigned to your department yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Complaint Status</h3>
            
            <form id="statusForm" method="POST">
                @csrf
                @method('POST')
                
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
                        <label class="block text-sm font-medium text-gray-700">Remarks</label>
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
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openStatusModal(complaintId, currentStatus) {
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('statusForm').action = `/department/complaints/${complaintId}/status`;
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
</script>
@endsection