@extends('layouts.app')

@section('title', 'Department Feedback - ComplaintHub')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Citizen Feedback</h1>
            <p class="text-gray-600 mt-2">
                Feedback received for complaints handled by 
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

    <!-- Feedback Statistics -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        @php
            $totalFeedback = $feedback->total();
            $avgRating = $feedback->avg('rating');
            $excellentCount = $feedback->where('rating', '>=', 4)->count();
            $poorCount = $feedback->where('rating', '<=', 2)->count();
        @endphp
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-comments text-blue-600"></i>
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
                    <i class="fas fa-star text-yellow-600"></i>
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
                    <i class="fas fa-thumbs-up text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Excellent (4-5★)</p>
                    <p class="text-2xl font-semibold">{{ $excellentCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-thumbs-down text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Needs Improvement (1-2★)</p>
                    <p class="text-2xl font-semibold">{{ $poorCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback List -->
    <div class="bg-white rounded-lg shadow">
        @if($feedback && $feedback->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Recent Feedback</h2>
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
                                            @if($item->complaint->user)
                                                <span><i class="fas fa-user mr-1"></i>{{ $item->complaint->user->name }}</span>
                                            @endif
                                            <span><i class="fas fa-calendar mr-1"></i>Resolved: {{ $item->complaint->updated_at ? $item->complaint->updated_at->format('M j, Y') : 'Unknown' }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Feedback Comment -->
                                @if($item->comment)
                                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 
                                        @if($item->rating >= 4) border-green-500
                                        @elseif($item->rating == 3) border-yellow-500
                                        @else border-red-500 @endif">
                                        <p class="text-gray-700 italic">"{{ $item->comment }}"</p>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">No comment provided</p>
                                @endif
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                @if($item->complaint)
                                    <a href="{{ route('department.show', $item->complaint) }}" 
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
                                            <i class="fas fa-frown mr-1"></i>Needs Work
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
                {{ $feedback->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-star text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No feedback yet</h3>
                <p class="text-gray-600 mb-6">Feedback will appear here once citizens rate resolved complaints from your department.</p>
                <a href="{{ route('department.complaints') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-list mr-2"></i>View Complaints
                </a>
            </div>
        @endif
    </div>

    <!-- Tips for Improvement -->
    @if($feedback && $feedback->count() > 0 && $avgRating < 4)
    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Tips for Improvement</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Respond to complaints promptly and keep citizens informed</li>
                        <li>Provide clear explanations of actions taken</li>
                        <li>Follow up to ensure the issue is fully resolved</li>
                        <li>Be courteous and professional in all communications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection