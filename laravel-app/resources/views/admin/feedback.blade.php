@extends('layouts.app')

@section('title', 'Feedback Management - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Feedback Management</h1>
            <p class="text-gray-600 mt-2">Monitor citizen feedback and service quality ratings</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Feedback Statistics -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        @php
            $totalFeedback = App\Models\Feedback::count();
            $avgRating = App\Models\Feedback::avg('rating');
            $excellentFeedback = App\Models\Feedback::where('rating', '>=', 4)->count();
            $poorFeedback = App\Models\Feedback::where('rating', '<=', 2)->count();
        @endphp
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-comments text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Feedback</p>
                    <p class="text-2xl font-semibold">{{ $totalFeedback }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Average Rating</p>
                    <p class="text-2xl font-semibold">{{ $avgRating ? number_format($avgRating, 1) : '0.0' }}/5</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-thumbs-up text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Excellent (4-5★)</p>
                    <p class="text-2xl font-semibold">{{ $excellentFeedback }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-thumbs-down text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Poor (1-2★)</p>
                    <p class="text-2xl font-semibold">{{ $poorFeedback }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Rating</label>
                <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
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
            
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
            
            @if(request()->hasAny(['rating', 'department']))
                <div>
                    <a href="{{ route('admin.feedback') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Feedback List -->
    <div class="bg-white rounded-lg shadow">
        @if($feedback && $feedback->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    All Feedback ({{ $feedback->total() }} total)
                </h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($feedback as $item)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Rating and Date -->
                                <div class="flex items-center space-x-4 mb-3">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $item->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                        <span class="text-sm text-gray-600 ml-2">({{ $item->rating }}/5)</span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $item->created_at ? $item->created_at->format('M j, Y g:i A') : 'Unknown date' }}
                                    </span>
                                </div>

                                <!-- Complaint Info -->
                                @if($item->complaint)
                                    <div class="mb-3">
                                        <h3 class="font-medium text-gray-900 mb-1">
                                            Complaint: {{ $item->complaint->title }}
                                        </h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span><i class="fas fa-tag mr-1"></i>{{ $item->complaint->category }}</span>
                                            @if($item->complaint->department)
                                                <span><i class="fas fa-building mr-1"></i>{{ $item->complaint->department->name }}</span>
                                            @endif
                                            @if($item->complaint->user)
                                                <span><i class="fas fa-user mr-1"></i>{{ $item->complaint->user->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Feedback Comment -->
                                @if($item->comment)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-gray-700 italic">"{{ $item->comment }}"</p>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">No comment provided</p>
                                @endif
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                @if($item->complaint)
                                    <a href="{{ route('complaints.show', $item->complaint) }}" 
                                       class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition text-center">
                                        <i class="fas fa-eye mr-1"></i>View Complaint
                                    </a>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($item->rating >= 4) bg-green-100 text-green-800
                                        @elseif($item->rating == 3) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($item->rating >= 4)
                                            <i class="fas fa-smile mr-1"></i>Excellent
                                        @elseif($item->rating == 3)
                                            <i class="fas fa-meh mr-1"></i>Average
                                        @else
                                            <i class="fas fa-frown mr-1"></i>Poor
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $feedback->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-star text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No feedback found</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['rating', 'department']))
                        No feedback matches your current filters.
                    @else
                        No feedback has been submitted yet.
                    @endif
                </p>
                @if(request()->hasAny(['rating', 'department']))
                    <a href="{{ route('admin.feedback') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection