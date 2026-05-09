@extends('layouts.app')

@section('title', 'Department Dashboard - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-orange-600 via-red-600 to-pink-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-orange-600/30 to-red-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center shadow-2xl mr-4">
                        <i class="fas fa-tools text-white text-2xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        Department 
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Dashboard
                        </span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-orange-100 mb-4 max-w-3xl mx-auto">
                    Welcome, <span class="font-bold text-yellow-300">{{ Auth::user()->name }}!</span>
                </p>
                <p class="text-lg text-orange-200 mb-8 max-w-2xl mx-auto">
                    🛠️ Department Manager Dashboard - 
                    @if(Auth::user()->department)
                        Manage complaints for <span class="font-semibold text-yellow-300">{{ Auth::user()->department->name }}</span>
                    @else
                        Handle assigned complaints and serve your community
                    @endif
                </p>
                
                <!-- Role Badge -->
                <div class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                    <div class="w-3 h-3 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
                    <span class="text-white font-semibold">Department Manager</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Assigned to Me</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        {{ $assignedComplaints ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">My responsibility</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-inbox text-white text-xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-tie text-white text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">In Progress</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-yellow-500 to-orange-500 bg-clip-text text-transparent">
                        {{ $pendingComplaints ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Currently working</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    @if(($pendingComplaints ?? 0) > 0)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-blue-500 rounded-full animate-pulse"></div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Resolved</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">
                        {{ $resolvedComplaints ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Successfully completed</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    @if(($resolvedComplaints ?? 0) > 0)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-medal text-white text-xs"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Department Actions -->
    <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-tools text-white"></i>
            </div>
            <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Department Actions</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            <a href="{{ route('department.complaints') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mr-6">
                        <i class="fas fa-tasks text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors duration-300">My Complaints</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">View and manage assigned complaints</p>
                        <div class="flex items-center mt-3 text-blue-600 font-medium text-sm">
                            <span>Manage Tasks</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('department.feedback') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-emerald-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mr-6">
                        <i class="fas fa-star text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">Citizen Feedback</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">View feedback from resolved complaints</p>
                        <div class="flex items-center mt-3 text-green-600 font-medium text-sm">
                            <span>View Reviews</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Performance Insights -->
    @if(Auth::user()->department)
    <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in mt-8" style="animation-delay: 0.4s;">
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-chart-line text-white"></i>
            </div>
            <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Department Insights</h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Department</span>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">{{ Auth::user()->department->name }}</h4>
                <p class="text-sm text-gray-600 leading-relaxed">{{ Auth::user()->department->description ?? 'Department description not available.' }}</p>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-percentage text-white"></i>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">Success Rate</span>
                </div>
                <h4 class="text-2xl font-bold text-green-600 mb-2">
                    {{ ($assignedComplaints ?? 0) > 0 ? round((($resolvedComplaints ?? 0) / ($assignedComplaints ?? 1)) * 100, 1) : 0 }}%
                </h4>
                <p class="text-sm text-gray-600">Resolution success rate</p>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-orange-50 to-red-50 rounded-xl border border-orange-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded-full">Workload</span>
                </div>
                <h4 class="text-2xl font-bold text-orange-600 mb-2">{{ $pendingComplaints ?? 0 }}</h4>
                <p class="text-sm text-gray-600">Active complaints to process</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection