@extends('layouts.app')

@section('title', 'My Complaints - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-emerald-600 to-teal-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-green-600/30 to-teal-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center shadow-2xl mr-4">
                        <i class="fas fa-list-alt text-white text-2xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        My 
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Complaints
                        </span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto">
                    📋 Track and manage all your submitted complaints in one place. Stay updated on progress and resolutions.
                </p>
                
                <!-- Action Button -->
                <a href="{{ route('complaints.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-white text-green-600 rounded-2xl font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-3"></i>
                    Submit New Complaint
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
    <!-- Stats Dashboard -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Complaints</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ $complaints->count() }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">All submissions</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-yellow-500 to-orange-500 bg-clip-text text-transparent">
                        {{ $complaints->where('status', 'pending')->count() }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting assignment</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    @if($complaints->where('status', 'pending')->count() > 0)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">In Progress</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-500 to-indigo-500 bg-clip-text text-transparent">
                        {{ $complaints->where('status', 'in-progress')->count() }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Being processed</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-cog text-white text-xl animate-spin" style="animation-duration: 3s;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Resolved</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">
                        {{ $complaints->where('status', 'resolved')->count() }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Successfully completed</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                    @if($complaints->where('status', 'resolved')->count() > 0)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-white text-xs"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="glass-effect rounded-2xl p-6 mb-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.4s;">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-filter text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Filter & Search</h3>
                    <p class="text-sm text-gray-600">Find specific complaints quickly</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search complaints..." 
                           class="pl-10 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <select id="status-filter" class="px-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
                
                <select id="priority-filter" class="px-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="glass-effect rounded-2xl border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.5s;">
        @if($complaints->count() > 0)
            <div class="px-8 py-6 border-b border-gray-200/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-list text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">All Complaints</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        <span id="showing-count">{{ $complaints->count() }}</span> complaints found
                    </div>
                </div>
            </div>
            
            <div id="complaints-container" class="divide-y divide-gray-200/50">
                @foreach($complaints as $complaint)
                    <div class="complaint-item p-8 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-300 group" 
                         data-status="{{ $complaint->status }}" 
                         data-priority="{{ $complaint->priority }}"
                         data-search="{{ strtolower($complaint->title . ' ' . $complaint->description . ' ' . $complaint->category . ' ' . ($complaint->address ?? '')) }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start space-x-4 mb-4">
                                    <!-- Status Icon -->
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg
                                        @if($complaint->status == 'pending') bg-gradient-to-r from-yellow-500 to-orange-500
                                        @elseif($complaint->status == 'in-progress') bg-gradient-to-r from-blue-500 to-indigo-500
                                        @elseif($complaint->status == 'resolved') bg-gradient-to-r from-green-500 to-emerald-500
                                        @else bg-gradient-to-r from-red-500 to-pink-500 @endif">
                                        @if($complaint->status == 'pending')
                                            <i class="fas fa-clock text-white"></i>
                                        @elseif($complaint->status == 'in-progress')
                                            <i class="fas fa-cog text-white"></i>
                                        @elseif($complaint->status == 'resolved')
                                            <i class="fas fa-check text-white"></i>
                                        @else
                                            <i class="fas fa-exclamation text-white"></i>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-3 mb-3">
                                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">
                                                {{ $complaint->title }}
                                            </h3>
                                            
                                            <!-- Complaint ID Badge -->
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono bg-purple-100 text-purple-800 border border-purple-200">
                                                <i class="fas fa-hashtag mr-1"></i>
                                                {{ $complaint->complaint_id ?? 'ID-PENDING' }}
                                            </span>
                                            
                                            <!-- Status Badge -->
                                            <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                                @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800 border border-blue-200
                                                @elseif($complaint->status == 'resolved') bg-green-100 text-green-800 border border-green-200
                                                @else bg-red-100 text-red-800 border border-red-200 @endif">
                                                <div class="w-2 h-2 rounded-full mr-2
                                                    @if($complaint->status == 'pending') bg-yellow-500
                                                    @elseif($complaint->status == 'in-progress') bg-blue-500
                                                    @elseif($complaint->status == 'resolved') bg-green-500
                                                    @else bg-red-500 @endif"></div>
                                                {{ ucfirst(str_replace('-', ' ', $complaint->status)) }}
                                            </span>
                                            
                                            <!-- Priority Badge -->
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                @if($complaint->priority == 'low') bg-gray-100 text-gray-800 border border-gray-200
                                                @elseif($complaint->priority == 'medium') bg-yellow-100 text-yellow-800 border border-yellow-200
                                                @elseif($complaint->priority == 'high') bg-orange-100 text-orange-800 border border-orange-200
                                                @else bg-red-100 text-red-800 border border-red-200 @endif">
                                                @if($complaint->priority == 'low')
                                                    <i class="fas fa-leaf mr-1"></i>
                                                @elseif($complaint->priority == 'medium')
                                                    <i class="fas fa-clock mr-1"></i>
                                                @elseif($complaint->priority == 'high')
                                                    <i class="fas fa-exclamation mr-1"></i>
                                                @else
                                                    <i class="fas fa-fire mr-1"></i>
                                                @endif
                                                {{ ucfirst($complaint->priority) }} Priority
                                            </span>
                                        </div>
                                        
                                        <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($complaint->description, 200) }}</p>
                                        
                                        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <i class="fas fa-tag text-blue-500 mr-2"></i>
                                                <span class="font-medium">{{ $complaint->category }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar text-green-500 mr-2"></i>
                                                <span>{{ $complaint->created_at->format('M j, Y') }}</span>
                                            </div>
                                            @if($complaint->address)
                                                <div class="flex items-center">
                                                    <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                                    <span>{{ Str::limit($complaint->address, 50) }}</span>
                                                </div>
                                            @endif
                                            @if($complaint->department)
                                                <div class="flex items-center">
                                                    <i class="fas fa-building text-indigo-500 mr-2"></i>
                                                    <span>{{ $complaint->department->name }}</span>
                                                </div>
                                            @endif
                                            @if($complaint->images && count($complaint->images) > 0)
                                                <div class="flex items-center">
                                                    <i class="fas fa-images text-pink-500 mr-2"></i>
                                                    <span>{{ count($complaint->images) }} {{ count($complaint->images) == 1 ? 'image' : 'images' }}</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center">
                                                <i class="fas fa-clock text-orange-500 mr-2"></i>
                                                <span>{{ $complaint->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 ml-6">
                                <a href="{{ route('complaints.show', $complaint) }}" 
                                   class="group/btn flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                    <i class="fas fa-eye mr-2 group-hover/btn:scale-110 transition-transform duration-300"></i>
                                    View Details
                                </a>
                                <a href="{{ route('complaints.track', $complaint) }}" 
                                   class="group/btn flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                    <i class="fas fa-route mr-2 group-hover/btn:scale-110 transition-transform duration-300"></i>
                                    Track Progress
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gradient-to-r from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No complaints yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                    You haven't submitted any complaints yet. Start by creating your first complaint to get help with any issues you're facing.
                </p>
                <a href="{{ route('complaints.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                    <i class="fas fa-plus mr-3"></i>
                    Submit Your First Complaint
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    @if($complaints->count() > 0)
    <div class="glass-effect rounded-2xl p-8 mt-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.6s;">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-rocket text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Quick Actions
            </h3>
            <p class="text-gray-600">Manage your complaints efficiently</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('complaints.create') }}" 
               class="group p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:shadow-lg transition-shadow duration-300">
                    <i class="fas fa-plus text-white group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors duration-300">New Complaint</h4>
                <p class="text-sm text-gray-600">Submit a new complaint for any issue</p>
            </a>
            
            <button onclick="filterByStatus('pending')" 
                    class="group p-6 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mb-4 group-hover:shadow-lg transition-shadow duration-300">
                    <i class="fas fa-clock text-white group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors duration-300">View Pending</h4>
                <p class="text-sm text-gray-600">Check complaints awaiting assignment</p>
            </button>
            
            <button onclick="filterByStatus('resolved')" 
                    class="group p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:shadow-lg transition-shadow duration-300">
                    <i class="fas fa-check text-white group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">View Resolved</h4>
                <p class="text-sm text-gray-600">See successfully resolved complaints</p>
            </button>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const priorityFilter = document.getElementById('priority-filter');
    const complaintsContainer = document.getElementById('complaints-container');
    const showingCount = document.getElementById('showing-count');
    
    function filterComplaints() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const priorityValue = priorityFilter.value;
        
        const complaints = document.querySelectorAll('.complaint-item');
        let visibleCount = 0;
        
        complaints.forEach(complaint => {
            const searchData = complaint.dataset.search;
            const status = complaint.dataset.status;
            const priority = complaint.dataset.priority;
            
            const matchesSearch = !searchTerm || searchData.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            const matchesPriority = !priorityValue || priority === priorityValue;
            
            if (matchesSearch && matchesStatus && matchesPriority) {
                complaint.style.display = 'block';
                visibleCount++;
            } else {
                complaint.style.display = 'none';
            }
        });
        
        if (showingCount) {
            showingCount.textContent = visibleCount;
        }
    }
    
    // Add event listeners
    if (searchInput) searchInput.addEventListener('input', filterComplaints);
    if (statusFilter) statusFilter.addEventListener('change', filterComplaints);
    if (priorityFilter) priorityFilter.addEventListener('change', filterComplaints);
    
    // Global filter functions
    window.filterByStatus = function(status) {
        statusFilter.value = status;
        filterComplaints();
        
        // Scroll to complaints section
        complaintsContainer.scrollIntoView({ behavior: 'smooth' });
    };
    
    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>
@endsection