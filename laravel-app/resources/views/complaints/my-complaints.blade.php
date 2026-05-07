@extends('layouts.app')

@section('title', 'My Complaints - ComplaintHub')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Complaints</h1>
            <p class="text-gray-600 mt-2">Track and manage all your submitted complaints</p>
        </div>
        <a href="{{ route('complaints.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>New Complaint
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
                    <p class="text-2xl font-semibold">{{ $complaints->count() }}</p>
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
                    <p class="text-2xl font-semibold">{{ $complaints->where('status', 'pending')->count() }}</p>
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
                    <p class="text-2xl font-semibold">{{ $complaints->where('status', 'in-progress')->count() }}</p>
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
                    <p class="text-2xl font-semibold">{{ $complaints->where('status', 'resolved')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="bg-white rounded-lg shadow">
        @if($complaints->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">All Complaints</h2>
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
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $complaint->created_at->format('M j, Y') }}</span>
                                    @if($complaint->department)
                                        <span><i class="fas fa-building mr-1"></i>{{ $complaint->department->name }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex space-x-2 ml-4">
                                <a href="{{ route('complaints.show', $complaint) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('complaints.track', $complaint) }}" 
                                   class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                    <i class="fas fa-route mr-1"></i>Track
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-clipboard-list text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No complaints yet</h3>
                <p class="text-gray-600 mb-6">You haven't submitted any complaints. Start by creating your first complaint.</p>
                <a href="{{ route('complaints.create') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Submit Your First Complaint
                </a>
            </div>
        @endif
    </div>
</div>
@endsection