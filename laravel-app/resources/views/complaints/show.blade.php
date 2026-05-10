@extends('layouts.app')

@section('title', 'Complaint Details - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/30 to-pink-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center shadow-2xl mr-4">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        Complaint 
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Details
                        </span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-indigo-100 mb-8 max-w-3xl mx-auto">
                    📄 Complete information about your complaint, including status updates and resolution progress.
                </p>
                
                <!-- Status Indicator -->
                <div class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                    <div class="w-3 h-3 rounded-full mr-3 animate-pulse
                        @if($complaint->status == 'pending') bg-yellow-400
                        @elseif($complaint->status == 'in-progress') bg-blue-400
                        @elseif($complaint->status == 'resolved') bg-green-400
                        @else bg-red-400 @endif"></div>
                    <span class="text-white font-semibold capitalize">{{ str_replace('-', ' ', $complaint->status) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 -mt-8 relative z-10">
    <!-- Navigation -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('complaints.my') }}" class="group flex items-center px-6 py-3 bg-white/90 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20">
            <i class="fas fa-arrow-left text-gray-600 mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-gray-700 font-medium">Back to My Complaints</span>
        </a>
        
        <div class="flex items-center space-x-4">
            <a href="{{ route('complaints.track', $complaint) }}" 
               class="group flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                <i class="fas fa-route mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                Track Progress
            </a>
        </div>
    </div>

    <!-- Main Complaint Card -->
    <div class="glass-effect rounded-3xl p-8 md:p-12 border border-white/20 shadow-2xl animate-fade-in mb-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-8">
            <div class="flex-1">
                <div class="flex items-start space-x-4 mb-6">
                    <!-- Status Icon -->
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg
                        @if($complaint->status == 'pending') bg-gradient-to-r from-yellow-500 to-orange-500
                        @elseif($complaint->status == 'in-progress') bg-gradient-to-r from-blue-500 to-indigo-500
                        @elseif($complaint->status == 'resolved') bg-gradient-to-r from-green-500 to-emerald-500
                        @else bg-gradient-to-r from-red-500 to-pink-500 @endif">
                        @if($complaint->status == 'pending')
                            <i class="fas fa-clock text-white text-xl"></i>
                        @elseif($complaint->status == 'in-progress')
                            <i class="fas fa-cog text-white text-xl"></i>
                        @elseif($complaint->status == 'resolved')
                            <i class="fas fa-check text-white text-xl"></i>
                        @else
                            <i class="fas fa-exclamation text-white text-xl"></i>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $complaint->title }}</h2>
                        
                        <!-- Meta Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar text-blue-500 mr-3 w-5"></i>
                                <span class="font-medium">Submitted:</span>
                                <span class="ml-2">{{ $complaint->created_at ? $complaint->created_at->format('M j, Y g:i A') : 'Unknown date' }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-tag text-green-500 mr-3 w-5"></i>
                                <span class="font-medium">Category:</span>
                                <span class="ml-2">{{ $complaint->category }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user text-purple-500 mr-3 w-5"></i>
                                <span class="font-medium">Submitted by:</span>
                                <span class="ml-2">{{ $complaint->user ? $complaint->user->name : 'Unknown user' }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock text-orange-500 mr-3 w-5"></i>
                                <span class="font-medium">Last updated:</span>
                                <span class="ml-2">{{ $complaint->updated_at ? $complaint->updated_at->diffForHumans() : 'Unknown' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status and Priority Badges -->
            <div class="flex flex-col space-y-3 lg:ml-8">
                <div class="status-badge inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold shadow-lg
                    @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800 border-2 border-yellow-200
                    @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800 border-2 border-blue-200
                    @elseif($complaint->status == 'resolved') bg-green-100 text-green-800 border-2 border-green-200
                    @else bg-red-100 text-red-800 border-2 border-red-200 @endif">
                    <div class="w-3 h-3 rounded-full mr-3
                        @if($complaint->status == 'pending') bg-yellow-500
                        @elseif($complaint->status == 'in-progress') bg-blue-500
                        @elseif($complaint->status == 'resolved') bg-green-500
                        @else bg-red-500 @endif"></div>
                    {{ ucfirst(str_replace('-', ' ', $complaint->status)) }}
                </div>
                
                <div class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold shadow-lg
                    @if($complaint->priority == 'low') bg-gray-100 text-gray-800 border-2 border-gray-200
                    @elseif($complaint->priority == 'medium') bg-yellow-100 text-yellow-800 border-2 border-yellow-200
                    @elseif($complaint->priority == 'high') bg-orange-100 text-orange-800 border-2 border-orange-200
                    @else bg-red-100 text-red-800 border-2 border-red-200 @endif">
                    @if($complaint->priority == 'low')
                        <i class="fas fa-leaf mr-2"></i>
                    @elseif($complaint->priority == 'medium')
                        <i class="fas fa-clock mr-2"></i>
                    @elseif($complaint->priority == 'high')
                        <i class="fas fa-exclamation mr-2"></i>
                    @else
                        <i class="fas fa-fire mr-2"></i>
                    @endif
                    {{ ucfirst($complaint->priority) }} Priority
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 mb-8 border border-gray-200">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-align-left text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Complaint Description</h3>
            </div>
            <p class="text-gray-700 leading-relaxed text-lg">{{ $complaint->description }}</p>
        </div>

        <!-- Address Section -->
        @if($complaint->address)
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 mb-8 border border-indigo-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Location/Address</h3>
                </div>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $complaint->address }}</p>
            </div>
        @endif

        <!-- Department Assignment -->
        @if($complaint->department)
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Assigned Department</h3>
                        <p class="text-purple-700 font-semibold">{{ $complaint->department->name }}</p>
                        @if($complaint->department->description)
                            <p class="text-sm text-gray-600 mt-1">{{ $complaint->department->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Status Timeline -->
    <div class="glass-effect rounded-3xl p-8 border border-white/20 shadow-2xl animate-fade-in mb-8" style="animation-delay: 0.2s;">
        <div class="flex items-center mb-8">
            <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-history text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Status Timeline</h3>
                <p class="text-gray-600">Track the progress of your complaint</p>
            </div>
        </div>
        
        @if($complaint->statusLogs && $complaint->statusLogs->count() > 0)
            <div class="space-y-6">
                @foreach($complaint->statusLogs->sortByDesc('created_at') as $index => $log)
                    <div class="relative">
                        <!-- Timeline Line -->
                        @if(!$loop->last)
                            <div class="absolute left-6 top-16 w-0.5 h-16 bg-gradient-to-b from-gray-300 to-gray-200"></div>
                        @endif
                        
                        <div class="flex items-start space-x-6 p-6 bg-gradient-to-r from-white to-gray-50 rounded-2xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-lg">
                            <!-- Status Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg
                                    @if($log->status == 'pending') bg-gradient-to-r from-yellow-500 to-orange-500
                                    @elseif($log->status == 'in-progress') bg-gradient-to-r from-blue-500 to-indigo-500
                                    @elseif($log->status == 'resolved') bg-gradient-to-r from-green-500 to-emerald-500
                                    @else bg-gradient-to-r from-red-500 to-pink-500 @endif">
                                    @if($log->status == 'pending')
                                        <i class="fas fa-clock text-white"></i>
                                    @elseif($log->status == 'in-progress')
                                        <i class="fas fa-cog text-white"></i>
                                    @elseif($log->status == 'resolved')
                                        <i class="fas fa-check text-white"></i>
                                    @else
                                        <i class="fas fa-exclamation text-white"></i>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                                    <h4 class="text-lg font-bold text-gray-900">
                                        Status changed to: 
                                        <span class="capitalize bg-gradient-to-r 
                                            @if($log->status == 'pending') from-yellow-600 to-orange-600
                                            @elseif($log->status == 'in-progress') from-blue-600 to-indigo-600
                                            @elseif($log->status == 'resolved') from-green-600 to-emerald-600
                                            @else from-red-600 to-pink-600 @endif
                                            bg-clip-text text-transparent">{{ str_replace('-', ' ', $log->status) }}</span>
                                    </h4>
                                    <div class="flex items-center text-sm text-gray-500 mt-2 sm:mt-0">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ $log->created_at ? $log->created_at->format('M j, Y g:i A') : 'Unknown date' }}
                                    </div>
                                </div>
                                
                                @if($log->remarks)
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-3">
                                        <div class="flex items-start">
                                            <i class="fas fa-comment text-blue-500 mr-3 mt-1"></i>
                                            <p class="text-gray-700 leading-relaxed">{{ $log->remarks }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Updated by: <span class="font-medium">{{ ($log->updatedBy && $log->updatedBy->name) ? $log->updatedBy->name : 'System' }}</span></span>
                                    @if($log->updatedBy && $log->updatedBy->role)
                                        <span class="ml-2 px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs capitalize">{{ $log->updatedBy->role }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-gray-400 text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">No status updates yet</h4>
                <p class="text-gray-600">Status updates will appear here as your complaint is processed</p>
            </div>
        @endif
    </div>

    <!-- Feedback Section -->
    @if($complaint->status == 'resolved' && !$complaint->feedback)
        <div class="glass-effect rounded-3xl p-8 border border-white/20 shadow-2xl animate-fade-in" style="animation-delay: 0.4s;">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                    Provide Feedback
                </h3>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Your complaint has been resolved! Help us improve our services by sharing your experience and rating the resolution quality.
                </p>
            </div>
            
            <form action="{{ route('complaints.feedback.store', $complaint) }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                <div class="space-y-8">
                    <!-- Rating Section -->
                    <div class="text-center">
                        <label class="block text-lg font-semibold text-gray-700 mb-4">How would you rate our service?</label>
                        <div class="flex items-center justify-center space-x-2 mb-4" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="rating-star text-4xl text-gray-300 hover:text-yellow-500 focus:outline-none transition-all duration-300 transform hover:scale-110" data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        <p class="text-sm text-gray-500">Click on stars to rate (1 = Poor, 5 = Excellent)</p>
                        <div id="rating-text" class="mt-2 text-lg font-medium text-gray-700 opacity-0 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Comment Section -->
                    <div>
                        <label for="comment" class="block text-lg font-semibold text-gray-700 mb-4">
                            <i class="fas fa-comment mr-2 text-blue-500"></i>
                            Share Your Experience (Optional)
                        </label>
                        <textarea name="comment" id="comment" rows="6" 
                                  class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all duration-300 resize-none"
                                  placeholder="Tell us about your experience... What went well? What could be improved? Your feedback helps us serve you better."></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-2xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold text-lg">
                            <i class="fas fa-paper-plane mr-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            Submit Feedback
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @elseif($complaint->feedback)
        <div class="glass-effect rounded-3xl p-8 border border-white/20 shadow-2xl animate-fade-in" style="animation-delay: 0.4s;">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                    Your Feedback
                </h3>
                <p class="text-gray-600">Thank you for taking the time to provide feedback!</p>
            </div>
            
            <div class="max-w-2xl mx-auto bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-8">
                <!-- Rating Display -->
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center space-x-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-3xl {{ $i <= $complaint->feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-600">
                        <span class="font-semibold text-lg text-green-700">{{ $complaint->feedback->rating }}/5 Stars</span>
                        <span>•</span>
                        <span>Submitted {{ $complaint->feedback->created_at ? $complaint->feedback->created_at->format('M j, Y g:i A') : 'Unknown date' }}</span>
                    </div>
                </div>
                
                <!-- Comment Display -->
                @if($complaint->feedback->comment)
                    <div class="bg-white rounded-xl p-6 border border-green-200">
                        <div class="flex items-start">
                            <i class="fas fa-quote-left text-green-500 text-xl mr-4 mt-1"></i>
                            <p class="text-gray-700 leading-relaxed text-lg italic">{{ $complaint->feedback->comment }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="text-center mt-6">
                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full font-medium">
                        <i class="fas fa-heart mr-2"></i>
                        Thank you for helping us improve!
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating-input');
    const ratingText = document.getElementById('rating-text');
    
    const ratingLabels = {
        1: '😞 Poor - Very unsatisfied',
        2: '😐 Fair - Somewhat unsatisfied', 
        3: '🙂 Good - Satisfied',
        4: '😊 Very Good - Very satisfied',
        5: '🤩 Excellent - Extremely satisfied'
    };
    
    if (stars.length > 0) {
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                ratingInput.value = rating;
                
                // Update star colors
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-500');
                    } else {
                        s.classList.remove('text-yellow-500');
                        s.classList.add('text-gray-300');
                    }
                });
                
                // Update rating text
                if (ratingText && ratingLabels[rating]) {
                    ratingText.textContent = ratingLabels[rating];
                    ratingText.classList.remove('opacity-0');
                    ratingText.classList.add('opacity-100');
                }
            });
            
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('text-yellow-400');
                    }
                });
                
                // Show preview text
                if (ratingText && ratingLabels[rating]) {
                    ratingText.textContent = ratingLabels[rating];
                    ratingText.classList.remove('opacity-0');
                    ratingText.classList.add('opacity-100');
                }
            });
            
            star.addEventListener('mouseleave', function() {
                stars.forEach(s => s.classList.remove('text-yellow-400'));
                
                // Hide preview text if no rating selected
                if (!ratingInput.value && ratingText) {
                    ratingText.classList.add('opacity-0');
                    ratingText.classList.remove('opacity-100');
                }
            });
        });
    }
});
</script>
@endsection