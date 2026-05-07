@extends('layouts.app')

@section('title', 'Complaint Details - ComplaintHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Complaint Details</h1>
        <a href="{{ route('complaints.my') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to My Complaints
        </a>
    </div>

    <!-- Complaint Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $complaint->title }}</h2>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span><i class="fas fa-calendar mr-1"></i>{{ $complaint->created_at ? $complaint->created_at->format('M j, Y g:i A') : 'Unknown date' }}</span>
                    <span><i class="fas fa-tag mr-1"></i>{{ $complaint->category }}</span>
                    <span><i class="fas fa-user mr-1"></i>{{ $complaint->user ? $complaint->user->name : 'Unknown user' }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800
                    @elseif($complaint->status == 'resolved') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($complaint->status) }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($complaint->priority == 'low') bg-gray-100 text-gray-800
                    @elseif($complaint->priority == 'medium') bg-yellow-100 text-yellow-800
                    @elseif($complaint->priority == 'high') bg-orange-100 text-orange-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($complaint->priority) }} Priority
                </span>
            </div>
        </div>

        <div class="border-t pt-4">
            <h3 class="font-medium text-gray-900 mb-2">Description</h3>
            <p class="text-gray-700 leading-relaxed">{{ $complaint->description }}</p>
        </div>

        @if($complaint->department)
            <div class="border-t pt-4 mt-4">
                <h3 class="font-medium text-gray-900 mb-2">Assigned Department</h3>
                <div class="flex items-center">
                    <i class="fas fa-building text-blue-600 mr-2"></i>
                    <span class="text-gray-700">{{ $complaint->department->name }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Status Timeline -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-history text-blue-600 mr-2"></i>Status History
        </h3>
        
        @if($complaint->statusLogs && $complaint->statusLogs->count() > 0)
            <div class="space-y-4">
                @foreach($complaint->statusLogs->sortByDesc('created_at') as $log)
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
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
                                <h4 class="font-medium text-gray-900">
                                    Status changed to: <span class="capitalize">{{ $log->status }}</span>
                                </h4>
                                <span class="text-sm text-gray-500">
                                    {{ $log->created_at ? $log->created_at->format('M j, Y g:i A') : 'Unknown date' }}
                                </span>
                            </div>
                            @if($log->remarks)
                                <p class="text-gray-600 mt-1">{{ $log->remarks }}</p>
                            @endif
                            <p class="text-sm text-gray-500 mt-1">
                                Updated by: {{ ($log->updatedBy && $log->updatedBy->name) ? $log->updatedBy->name : 'System' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-clock text-gray-400 text-3xl mb-2"></i>
                <p class="text-gray-600">No status updates yet</p>
            </div>
        @endif
    </div>

    <!-- Feedback Section -->
    @if($complaint->status == 'resolved' && !$complaint->feedback)
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-star text-yellow-500 mr-2"></i>Provide Feedback
            </h3>
            <form action="#" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-500 focus:text-yellow-500">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                        <textarea name="comment" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Share your experience..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    @elseif($complaint->feedback)
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-star text-yellow-500 mr-2"></i>Your Feedback
            </h3>
            <div class="flex items-center space-x-2 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $complaint->feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                @endfor
                <span class="text-sm text-gray-600">({{ $complaint->feedback->rating }}/5)</span>
            </div>
            @if($complaint->feedback->comment)
                <p class="text-gray-700">{{ $complaint->feedback->comment }}</p>
            @endif
        </div>
    @endif
</div>
@endsection