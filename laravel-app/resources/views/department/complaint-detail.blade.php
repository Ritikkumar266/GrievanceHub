@extends('layouts.app')

@section('title', 'Complaint Details - ComplaintHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Complaint Details</h1>
            <p class="text-gray-600 mt-2">Review and manage complaint information</p>
        </div>
        <a href="{{ route('department.complaints') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Complaints
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                    <div class="flex space-x-2">
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
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-900 leading-relaxed">{{ $complaint->description }}</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Category</h3>
                            <p class="text-gray-900">{{ $complaint->category }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Submitted Date</h3>
                            <p class="text-gray-900">{{ $complaint->created_at ? $complaint->created_at->format('M j, Y g:i A') : 'Unknown' }}</p>
                        </div>
                    </div>

                    @if($complaint->user)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Submitted By</h3>
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-gray-900 font-medium">{{ $complaint->user->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $complaint->user->email }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status History -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Status History</h2>
                
                @if($complaint->statusLogs && $complaint->statusLogs->count() > 0)
                    <div class="space-y-4">
                        @foreach($complaint->statusLogs->sortByDesc('created_at') as $log)
                            <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full flex items-center justify-center
                                        @if($log->status == 'pending') bg-yellow-100
                                        @elseif($log->status == 'in-progress') bg-blue-100
                                        @elseif($log->status == 'resolved') bg-green-100
                                        @else bg-red-100 @endif">
                                        <i class="fas fa-circle text-xs
                                            @if($log->status == 'pending') text-yellow-600
                                            @elseif($log->status == 'in-progress') text-blue-600
                                            @elseif($log->status == 'resolved') text-green-600
                                            @else text-red-600 @endif"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            Status changed to: {{ ucfirst($log->status) }}
                                        </h3>
                                        <span class="text-xs text-gray-500">
                                            {{ $log->created_at ? $log->created_at->format('M j, Y g:i A') : 'Unknown time' }}
                                        </span>
                                    </div>
                                    @if($log->updatedBy)
                                        <p class="text-xs text-gray-500 mt-1">
                                            Updated by: {{ $log->updatedBy->name }}
                                        </p>
                                    @endif
                                    @if($log->remarks)
                                        <p class="text-sm text-gray-600 mt-1">{{ $log->remarks }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No status history available.</p>
                @endif
            </div>

            <!-- Feedback Section -->
            @if($complaint->feedback && $complaint->feedback->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Citizen Feedback</h2>
                
                <div class="space-y-4">
                    @foreach($complaint->feedback as $feedback)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">Rating:</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ $feedback->created_at ? $feedback->created_at->format('M j, Y') : 'Unknown date' }}
                                </span>
                            </div>
                            @if($feedback->comment)
                                <p class="text-gray-700">{{ $feedback->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            @if($complaint->status != 'resolved')
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <button onclick="openStatusModal('{{ $complaint->id }}', '{{ $complaint->status }}')" 
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-edit mr-2"></i>Update Status
                    </button>
                    
                    @if($complaint->status == 'pending')
                        <button onclick="updateQuickStatus('{{ $complaint->id }}', 'in-progress')" 
                                class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                            <i class="fas fa-play mr-2"></i>Start Working
                        </button>
                    @endif
                    
                    @if($complaint->status == 'in-progress')
                        <button onclick="updateQuickStatus('{{ $complaint->id }}', 'resolved')" 
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check mr-2"></i>Mark Resolved
                        </button>
                    @endif
                </div>
            </div>
            @endif

            <!-- Department Info -->
            @if($complaint->department)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Assigned Department</h3>
                
                <div class="space-y-2">
                    <p class="text-gray-900 font-medium">{{ $complaint->department->name }}</p>
                    @if($complaint->department->email)
                        <p class="text-gray-600 text-sm">{{ $complaint->department->email }}</p>
                    @endif
                    @if($complaint->department->description)
                        <p class="text-gray-600 text-sm">{{ $complaint->department->description }}</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Complaint Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Complaint Info</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="text-gray-900 font-mono text-sm">{{ Str::limit($complaint->id, 8) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Priority:</span>
                        <span class="text-gray-900">{{ ucfirst($complaint->priority) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category:</span>
                        <span class="text-gray-900">{{ $complaint->category }}</span>
                    </div>
                    @if($complaint->updated_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 text-sm">{{ $complaint->updated_at->format('M j, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
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

function updateQuickStatus(complaintId, status) {
    if (confirm(`Are you sure you want to change the status to "${status}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/department/complaints/${complaintId}/status`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        const remarksInput = document.createElement('input');
        remarksInput.type = 'hidden';
        remarksInput.name = 'remarks';
        remarksInput.value = `Status updated to ${status} via quick action`;
        
        form.appendChild(csrfToken);
        form.appendChild(statusInput);
        form.appendChild(remarksInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection