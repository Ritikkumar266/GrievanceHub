@extends('layouts.app')

@section('title', 'Complaint Details - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Complaint Details</h1>
            <p class="text-gray-600 mt-2">Review and manage complaint information (Admin View)</p>
        </div>
        <a href="{{ route('admin.complaints') }}" 
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

                    @if($complaint->address)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Location/Address</h3>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                            <p class="text-gray-900">{{ $complaint->address }}</p>
                        </div>
                    </div>
                    @endif

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

            <!-- Attached Images -->
            @if($complaint->images && count($complaint->images) > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-images text-pink-500 mr-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Attached Images</h2>
                    <span class="ml-2 text-sm text-gray-500">({{ count($complaint->images) }} {{ count($complaint->images) == 1 ? 'image' : 'images' }})</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($complaint->image_urls as $index => $imageUrl)
                        <div class="group relative">
                            <div class="aspect-square rounded-xl overflow-hidden border-2 border-gray-200 hover:border-pink-400 transition-all duration-300 cursor-pointer"
                                 onclick="openImageModal('{{ $imageUrl }}', {{ $index + 1 }})">
                                <img src="{{ $imageUrl }}" 
                                     alt="Complaint Image {{ $index + 1 }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-xl flex items-center justify-center">
                                <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-2xl"></i>
                            </div>
                            <div class="mt-2 text-center">
                                <span class="text-xs text-gray-600">Image {{ $index + 1 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 text-xs text-gray-500 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Click on any image to view in full size
                </div>
            </div>
            @endif

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
                                            @if($log->updatedBy->role)
                                                <span class="ml-1 px-2 py-0.5 bg-gray-200 text-gray-600 rounded-full text-xs capitalize">{{ $log->updatedBy->role }}</span>
                                            @endif
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
            @if($complaint->feedback)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Citizen Feedback</h2>
                
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">Rating:</span>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm {{ $i <= $complaint->feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-green-700">{{ $complaint->feedback->rating }}/5</span>
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $complaint->feedback->created_at ? $complaint->feedback->created_at->format('M j, Y') : 'Unknown date' }}
                        </span>
                    </div>
                    @if($complaint->feedback->comment)
                        <p class="text-gray-700 mt-2">{{ $complaint->feedback->comment }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    @if($complaint->status != 'resolved')
                        <button onclick="openStatusModal('{{ $complaint->id }}', '{{ $complaint->status }}')" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-2"></i>Update Status
                        </button>
                    @endif

                    @if(!$complaint->department_id)
                        <button onclick="openAssignModal('{{ $complaint->id }}')" 
                                class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-hand-point-right mr-2"></i>Assign Department
                        </button>
                    @endif
                </div>
            </div>

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

            <!-- Complaint Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Complaint Info</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Complaint ID:</span>
                        <span class="text-gray-900 font-mono text-sm">{{ $complaint->complaint_id ?? 'Not assigned' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Priority:</span>
                        <span class="text-gray-900">{{ ucfirst($complaint->priority) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category:</span>
                        <span class="text-gray-900">{{ $complaint->category }}</span>
                    </div>
                    @if($complaint->images && count($complaint->images) > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Images:</span>
                        <span class="text-gray-900">{{ count($complaint->images) }} attached</span>
                    </div>
                    @endif
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

// Image modal functionality
function openImageModal(imageUrl, imageNumber) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const imageCounter = document.getElementById('imageCounter');
    
    modalImage.src = imageUrl;
    imageCounter.textContent = `Image ${imageNumber}`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
});
</script>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" 
                class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors duration-200 z-10">
            <i class="fas fa-times text-gray-600"></i>
        </button>
        
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-4 bg-gray-50 border-b">
                <h3 class="text-lg font-semibold text-gray-800" id="imageCounter">Image</h3>
            </div>
            <div class="p-4">
                <img id="modalImage" src="" alt="Complaint Image" 
                     class="max-w-full max-h-[70vh] object-contain mx-auto rounded-lg">
            </div>
        </div>
    </div>
</div>
@endsection
