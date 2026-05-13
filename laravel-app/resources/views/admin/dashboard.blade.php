@extends('layouts.app')

@section('title', 'Admin Dashboard - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/30 to-blue-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    <div class="absolute top-24 right-1/3 w-8 h-8 bg-white/10 rounded-lg rotate-45 animate-bounce-subtle" style="animation-delay: 1.5s;"></div>
    <div class="absolute bottom-12 right-1/4 w-14 h-14 bg-yellow-300/10 rounded-full animate-bounce-subtle" style="animation-delay: 0.8s;"></div>
    <div class="absolute top-1/2 left-20 w-6 h-6 bg-white/15 rounded-full animate-bounce-subtle" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-28 right-12 w-10 h-10 bg-pink-300/10 rounded-lg rotate-12 animate-bounce-subtle" style="animation-delay: 1.3s;"></div>
    <div class="absolute top-14 left-1/2 w-5 h-5 bg-cyan-300/15 rounded-full animate-pulse"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center shadow-2xl mr-4">
                        <i class="fas fa-crown text-white text-2xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        Admin 
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Control Center
                        </span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-purple-100 mb-8 max-w-3xl mx-auto">
                    👑 System Administrator Dashboard - Manage complaints, departments, and oversee the entire platform
                </p>
                
                <!-- Role Badge -->
                <div class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                    <span class="text-white font-semibold">Administrator Access</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
    <!-- Primary Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Complaints</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ $totalComplaints }}
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
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-yellow-500 to-red-500 bg-clip-text text-transparent">
                        {{ $pendingComplaints }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Needs attention</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    @if($pendingComplaints > 0)
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
                        {{ $inProgressComplaints }}
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
                        {{ $resolvedComplaints }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Successfully completed</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                    @if($resolvedComplaints > 0)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-trophy text-white text-xs"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Departments</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">
                        {{ $departments }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Active departments</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-building text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.5s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-indigo-500 to-blue-500 bg-clip-text text-transparent">
                        {{ $totalUsers }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Registered users</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.6s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Citizens</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-teal-500 bg-clip-text text-transparent">
                        {{ $citizenUsers }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Citizen accounts</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-effect rounded-2xl p-6 card-hover animate-fade-in border border-white/20 shadow-xl" style="animation-delay: 0.7s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Dept Managers</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                        {{ $departmentUsers }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Department staff</p>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-tie text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <!-- Department Statistics -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.8s;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-white text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Department Performance
                </h3>
            </div>
            
            @if($departmentStats && $departmentStats->count() > 0)
                <div class="space-y-4">
                    @foreach($departmentStats->sortByDesc('complaints_count')->take(5) as $dept)
                        <div class="group p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ Str::limit($dept->name, 25) }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-bold text-blue-600">{{ $dept->complaints_count }}</span>
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building text-white text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-500 ease-out" 
                                     style="width: {{ $totalComplaints > 0 ? ($dept->complaints_count / $totalComplaints) * 100 : 0 }}%"></div>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                {{ $totalComplaints > 0 ? round(($dept->complaints_count / $totalComplaints) * 100, 1) : 0 }}% of total complaints
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.departments') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span>View All Departments</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-600">No department data available.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.9s;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Quick Actions
                </h3>
            </div>
            
            <div class="space-y-4">
                <a href="{{ route('admin.complaints') }}" 
                   class="group flex items-center w-full p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                        <i class="fas fa-list text-white group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">View All Complaints</h4>
                        <p class="text-sm text-gray-600">Manage system-wide complaints</p>
                    </div>
                    <i class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                
                <a href="{{ route('admin.departments') }}" 
                   class="group flex items-center w-full p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                        <i class="fas fa-building text-white group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">Manage Departments</h4>
                        <p class="text-sm text-gray-600">Configure department settings</p>
                    </div>
                    <i class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                
                <a href="{{ route('admin.feedback') }}" 
                   class="group flex items-center w-full p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                        <i class="fas fa-star text-white group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">View Feedback</h4>
                        <p class="text-sm text-gray-600">Citizen satisfaction reports</p>
                    </div>
                    <i class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                
                <a href="{{ route('admin.complaints') }}?status=pending" 
                   class="group flex items-center w-full p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                        <i class="fas fa-clock text-white group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 group-hover:text-yellow-600 transition-colors duration-300">Pending Complaints</h4>
                        <p class="text-sm text-gray-600">Requires immediate attention</p>
                    </div>
                    <i class="fas fa-arrow-right text-yellow-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                
                <button onclick="window.location.reload()" 
                        class="group flex items-center w-full p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border-2 border-gray-200 hover:border-gray-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-300">
                        <i class="fas fa-sync text-white group-hover:scale-110 group-hover:rotate-180 transition-all duration-300"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 group-hover:text-gray-600 transition-colors duration-300">Refresh Dashboard</h4>
                        <p class="text-sm text-gray-600">Update all statistics</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- System Analytics Grid -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <!-- System Status -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 1.0s;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    System Analytics
                </h3>
            </div>
            
            <div class="space-y-6">
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">Resolution Rate</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-green-600">
                            {{ $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100, 1) : 0 }}%
                        </span>
                        <p class="text-xs text-gray-500">Success rate</p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border border-yellow-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">Pending Rate</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-yellow-600">
                            {{ $totalComplaints > 0 ? round(($pendingComplaints / $totalComplaints) * 100, 1) : 0 }}%
                        </span>
                        <p class="text-xs text-gray-500">Awaiting action</p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">In Progress Rate</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-blue-600">
                            {{ $totalComplaints > 0 ? round(($inProgressComplaints / $totalComplaints) * 100, 1) : 0 }}%
                        </span>
                        <p class="text-xs text-gray-500">Being processed</p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">Active Departments</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-purple-600">{{ $departments }}</span>
                        <p class="text-xs text-gray-500">Operational units</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 1.1s;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    System Information
                </h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border border-gray-200">
                    <span class="font-medium text-gray-700">Laravel Version</span>
                    <span class="font-bold text-blue-600">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-green-50 rounded-lg border border-gray-200">
                    <span class="font-medium text-gray-700">Database</span>
                    <span class="font-bold text-green-600">MongoDB</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-purple-50 rounded-lg border border-gray-200">
                    <span class="font-medium text-gray-700">Environment</span>
                    <span class="font-bold text-purple-600 capitalize">{{ app()->environment() }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-lg border border-gray-200">
                    <span class="font-medium text-gray-700">Total Citizens</span>
                    <span class="font-bold text-indigo-600">{{ $citizenUsers }}</span>
                </div>
                
                <!-- Performance Indicator -->
                <div class="mt-6 p-4 bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl border border-green-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse mr-3"></div>
                            <span class="font-semibold text-green-800">System Status</span>
                        </div>
                        <span class="px-3 py-1 bg-green-500 text-white text-sm font-medium rounded-full">
                            Operational
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="glass-effect rounded-2xl border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 1.2s;">
        <div class="px-8 py-6 border-b border-gray-200/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Recent Activity</h2>
                </div>
                <a href="{{ route('admin.complaints') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    View All
                </a>
            </div>
        </div>
        
        <div class="p-8">
            @if($recentComplaints && $recentComplaints->count() > 0)
                <div class="space-y-4">
                    @foreach($recentComplaints as $complaint)
                        <div class="group p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border border-gray-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-2">
                                                {{ $complaint->title }}
                                            </h4>
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                                                <div class="flex items-center">
                                                    <i class="fas fa-user text-gray-400 mr-2"></i>
                                                    <span>{{ $complaint->user ? $complaint->user->name : 'Unknown' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-tag text-gray-400 mr-2"></i>
                                                    <span>{{ $complaint->category }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                                    <span>{{ $complaint->created_at ? $complaint->created_at->format('M j, Y') : 'Unknown date' }}</span>
                                                </div>
                                                @if($complaint->department)
                                                    <div class="flex items-center">
                                                        <i class="fas fa-building text-gray-400 mr-2"></i>
                                                        <span>{{ $complaint->department->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
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
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                    <a href="{{ route('admin.complaints') }}" 
                                       class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 group-hover:border-blue-400 group-hover:text-blue-600">
                                        <span class="text-sm font-medium">View</span>
                                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 text-center">
                    <a href="{{ route('admin.complaints') }}" 
                       class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span>View All Complaints</span>
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">No complaints yet</h3>
                    <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                        Complaints will appear here once citizens start submitting them. The system is ready to receive and process complaints.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection