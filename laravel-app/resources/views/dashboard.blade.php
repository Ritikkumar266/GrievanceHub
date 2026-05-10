@extends('layouts.app')

@section('title', 'Dashboard - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/30 to-purple-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Welcome back, 
                    <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                        {{ Auth::user()->name }}!
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    @if(Auth::user()->role == 'citizen')
                        🏛️ Your voice matters. Manage your complaints and track their progress in real-time.
                    @elseif(Auth::user()->role == 'admin')
                        👑 System Administrator. Oversee all complaints and manage the entire platform.
                    @else
                        🛠️ Department Manager. Handle assigned complaints and serve your community.
                    @endif
                </p>
                
                <!-- Role Badge -->
                <div class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                    <span class="text-white font-semibold capitalize">{{ Auth::user()->role }} Dashboard</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">

    @if(Auth::user()->role == 'citizen')
        <!-- Citizen Dashboard -->
        <!-- Stats Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Complaints</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $complaints->count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">All time submissions</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xs"></i>
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

        <!-- Quick Actions -->
        <div class="glass-effect rounded-2xl p-8 mb-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.4s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Quick Actions</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <a href="{{ route('complaints.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mr-6">
                            <i class="fas fa-plus text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors duration-300">Submit New Complaint</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Report an issue or concern to the relevant department</p>
                            <div class="flex items-center mt-3 text-blue-600 font-medium text-sm">
                                <span>Get Started</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('complaints.my') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-emerald-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mr-6">
                            <i class="fas fa-list-alt text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">View My Complaints</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Track progress and updates on your submitted complaints</p>
                            <div class="flex items-center mt-3 text-green-600 font-medium text-sm">
                                <span>Track Progress</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    @elseif(Auth::user()->role == 'admin')
        <!-- Admin Dashboard -->
        <!-- Stats Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Complaints</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $complaints->count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">System-wide submissions</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-white text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pending Assignment</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-yellow-500 to-red-500 bg-clip-text text-transparent">
                            {{ $complaints->where('status', 'pending')->count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Needs attention</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
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
                        <p class="text-sm font-medium text-gray-600 mb-1">Departments</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-purple-500 to-indigo-500 bg-clip-text text-transparent">
                            {{ App\Models\Department::count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Active departments</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Resolution Rate</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">
                            @php
                                $totalComplaints = $complaints->count();
                                $resolvedComplaints = $complaints->where('status', 'resolved')->count();
                                $percentage = $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100) : 0;
                            @endphp
                            {{ $percentage }}%
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Success rate</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        @php
                            $totalComplaints = $complaints->count();
                            $resolvedComplaints = $complaints->where('status', 'resolved')->count();
                            $hasHighResolutionRate = $totalComplaints > 0 && ($resolvedComplaints / $totalComplaints) > 0.8;
                        @endphp
                        @if($hasHighResolutionRate)
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-trophy text-white text-xs"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Quick Actions -->
        <div class="glass-effect rounded-2xl p-8 mb-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.4s;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-crown text-white"></i>
                </div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Admin Control Center</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <a href="{{ route('admin.complaints') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mx-auto mb-4">
                            <i class="fas fa-list text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors duration-300">All Complaints</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">View and manage all system complaints</p>
                        <div class="flex items-center justify-center mt-3 text-blue-600 font-medium text-sm">
                            <span>Manage</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.departments') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-pink-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mx-auto mb-4">
                            <i class="fas fa-building text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors duration-300">Manage Departments</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Add and edit department information</p>
                        <div class="flex items-center justify-center mt-3 text-purple-600 font-medium text-sm">
                            <span>Configure</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.feedback') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-emerald-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300 mx-auto mb-4">
                            <i class="fas fa-star text-white text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">System Analytics</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">View feedback and system reports</p>
                        <div class="flex items-center justify-center mt-3 text-green-600 font-medium text-sm">
                            <span>Analyze</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    @else
        <!-- Department Dashboard -->
        <!-- Stats Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Assigned to Me</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ $complaints->count() }}
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
                            {{ $complaints->where('status', 'in-progress')->count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Currently working</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        @if($complaints->where('status', 'in-progress')->count() > 0)
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
                            {{ $complaints->where('status', 'resolved')->count() }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Successfully completed</p>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        @if($complaints->where('status', 'resolved')->count() > 0)
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-medal text-white text-xs"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Quick Actions -->
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
    @endif
</div>
@endsection