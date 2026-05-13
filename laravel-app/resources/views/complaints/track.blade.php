@extends('layouts.app')

@section('title', 'Track Complaint - ComplaintHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Track Complaint</h1>
        <a href="{{ route('complaints.my') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to My Complaints
        </a>
    </div>

    <!-- Complaint Summary -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $complaint->title }}</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-mono bg-purple-100 text-purple-800 border border-purple-200">
                        <i class="fas fa-hashtag mr-1"></i>
                        {{ $complaint->complaint_id ?? 'ID-PENDING' }}
                    </span>
                </div>
                <p class="text-gray-600 mb-4">{{ Str::limit($complaint->description, 150) }}</p>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span><i class="fas fa-calendar mr-1"></i>Submitted: {{ $complaint->created_at ? $complaint->created_at->format('M j, Y') : 'Unknown date' }}</span>
                    <span><i class="fas fa-tag mr-1"></i>{{ $complaint->category }}</span>
                    @if($complaint->department)
                        <span><i class="fas fa-building mr-1"></i>{{ $complaint->department->name }}</span>
                    @endif
                    @if($complaint->images && count($complaint->images) > 0)
                        <span><i class="fas fa-images mr-1 text-pink-500"></i>{{ count($complaint->images) }} {{ count($complaint->images) == 1 ? 'image' : 'images' }}</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800
                    @elseif($complaint->status == 'resolved') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($complaint->status) }}
                </span>
                <p class="text-sm text-gray-500 mt-2">
                    Last updated: {{ $complaint->updated_at ? $complaint->updated_at->format('M j, Y g:i A') : 'Unknown date' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Progress Timeline -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">
            <i class="fas fa-route text-blue-600 mr-2"></i>Progress Timeline
        </h3>

        <!-- Progress Steps -->
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
            
            <div class="space-y-8">
                <!-- Step 1: Submitted -->
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Complaint Submitted</h4>
                        <p class="text-sm text-gray-600">Your complaint has been received and is being reviewed.</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $complaint->created_at ? $complaint->created_at->format('M j, Y g:i A') : 'Unknown date' }}</p>
                    </div>
                </div>

                <!-- Step 2: Under Review -->
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 {{ $complaint->status != 'pending' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-full flex items-center justify-center">
                        @if($complaint->status != 'pending')
                            <i class="fas fa-check text-white text-sm"></i>
                        @else
                            <i class="fas fa-clock text-white text-sm"></i>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Under Review</h4>
                        <p class="text-sm text-gray-600">
                            @if($complaint->status == 'pending')
                                Your complaint is currently being reviewed by our team.
                            @else
                                Your complaint has been reviewed and processed.
                            @endif
                        </p>
                        @if($complaint->department)
                            <p class="text-xs text-gray-500 mt-1">Assigned to: {{ $complaint->department->name }}</p>
                        @endif
                    </div>
                </div>

                <!-- Step 3: In Progress -->
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 {{ in_array($complaint->status, ['in-progress', 'resolved']) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                        @if(in_array($complaint->status, ['in-progress', 'resolved']))
                            <i class="fas fa-check text-white text-sm"></i>
                        @else
                            <i class="fas fa-circle text-white text-xs"></i>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium {{ in_array($complaint->status, ['in-progress', 'resolved']) ? 'text-gray-900' : 'text-gray-500' }}">
                            In Progress
                        </h4>
                        <p class="text-sm {{ in_array($complaint->status, ['in-progress', 'resolved']) ? 'text-gray-600' : 'text-gray-400' }}">
                            @if($complaint->status == 'in-progress')
                                Work is currently in progress to resolve your complaint.
                            @elseif($complaint->status == 'resolved')
                                Work has been completed to resolve your complaint.
                            @else
                                Your complaint will be worked on once it's assigned.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Step 4: Resolved -->
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 {{ $complaint->status == 'resolved' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                        @if($complaint->status == 'resolved')
                            <i class="fas fa-check text-white text-sm"></i>
                        @else
                            <i class="fas fa-circle text-white text-xs"></i>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium {{ $complaint->status == 'resolved' ? 'text-gray-900' : 'text-gray-500' }}">
                            Resolved
                        </h4>
                        <p class="text-sm {{ $complaint->status == 'resolved' ? 'text-gray-600' : 'text-gray-400' }}">
                            @if($complaint->status == 'resolved')
                                Your complaint has been successfully resolved!
                            @else
                                Your complaint will be marked as resolved once the work is complete.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Updates -->
        @if($complaint->statusLogs && $complaint->statusLogs->count() > 0)
            <div class="mt-8 pt-6 border-t">
                <h4 class="font-medium text-gray-900 mb-4">Recent Updates</h4>
                <div class="space-y-3">
                    @foreach($complaint->statusLogs->sortByDesc('created_at')->take(3) as $log)
                        <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center
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
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    Status updated to: <span class="capitalize">{{ $log->status }}</span>
                                </p>
                                @if($log->updatedBy)
                                    <p class="text-xs text-gray-500">
                                        Updated by: {{ $log->updatedBy->name }}
                                    </p>
                                @endif
                                @if($log->remarks)
                                    <p class="text-sm text-gray-600 mt-1">{{ $log->remarks }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $log->created_at ? $log->created_at->format('M j, Y g:i A') : 'Unknown date' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between mt-6">
        <a href="{{ route('complaints.show', $complaint) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-eye mr-2"></i>View Full Details
        </a>
        
        @if($complaint->status == 'resolved' && !$complaint->feedback)
            <button onclick="openFeedbackModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-star mr-2"></i>Provide Feedback
            </button>
        @endif
    </div>
</div>

<!-- Feedback Modal -->
@if($complaint->status == 'resolved' && !$complaint->feedback)
<div id="feedbackModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-star text-yellow-500 mr-2"></i>Provide Feedback
            </h3>
            
            <form action="{{ route('complaints.feedback.store', $complaint) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center space-x-1" id="modal-rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="modal-rating-star text-2xl text-gray-300 hover:text-yellow-500 focus:outline-none" data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="modal-rating-input" required>
                        <p class="text-sm text-gray-500 mt-1">Click on stars to rate (1-5)</p>
                    </div>
                    
                    <div>
                        <label for="modal-comment" class="block text-sm font-medium text-gray-700 mb-2">Comments (Optional)</label>
                        <textarea name="comment" id="modal-comment" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Share your experience..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="closeFeedbackModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
function openFeedbackModal() {
    document.getElementById('feedbackModal').classList.remove('hidden');
}

function closeFeedbackModal() {
    document.getElementById('feedbackModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const modalStars = document.querySelectorAll('.modal-rating-star');
    const modalRatingInput = document.getElementById('modal-rating-input');
    
    if (modalStars.length > 0) {
        modalStars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                modalRatingInput.value = rating;
                
                // Update star colors
                modalStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-500');
                    } else {
                        s.classList.remove('text-yellow-500');
                        s.classList.add('text-gray-300');
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                modalStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('text-yellow-400');
                    }
                });
            });
            
            star.addEventListener('mouseleave', function() {
                modalStars.forEach(s => s.classList.remove('text-yellow-400'));
            });
        });
    }
});
</script>
@endsection