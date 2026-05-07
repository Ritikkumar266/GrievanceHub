@extends('layouts.app')

@section('title', 'Dashboard - ComplaintHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-2">
            @if(Auth::user()->role == 'citizen')
                Manage your complaints and track their progress.
            @elseif(Auth::user()->role == 'admin')
                Oversee all complaints and manage the system.
            @else
                Handle assigned complaints and update their status.
            @endif
        </p>
    </div>

    @if(Auth::user()->role == 'citizen')
        <!-- Citizen Dashboard -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-plus text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Complaints</p>
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

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('complaints.create') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                    <i class="fas fa-plus text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Submit New Complaint</h3>
                        <p class="text-gray-600 text-sm">Report an issue or concern</p>
                    </div>
                </a>
                
                <a href="{{ route('complaints.my') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                    <i class="fas fa-list text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">View My Complaints</h3>
                        <p class="text-gray-600 text-sm">Track your submitted complaints</p>
                    </div>
                </a>
            </div>
        </div>

    @elseif(Auth::user()->role == 'admin')
        <!-- Admin Dashboard -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Complaints</p>
                        <p class="text-2xl font-semibold">{{ $complaints->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Pending Assignment</p>
                        <p class="text-2xl font-semibold">{{ $complaints->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-building text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Departments</p>
                        <p class="text-2xl font-semibold">{{ App\Models\Department::count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-chart-line text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Resolution Rate</p>
                        <p class="text-2xl font-semibold">{{ $complaints->count() > 0 ? round(($complaints->where('status', 'resolved')->count() / $complaints->count()) * 100) : 0 }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Admin Actions</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <a href="{{ route('admin.complaints') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                    <i class="fas fa-list text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">All Complaints</h3>
                        <p class="text-gray-600 text-sm">View and manage complaints</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.departments') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition">
                    <i class="fas fa-building text-purple-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Manage Departments</h3>
                        <p class="text-gray-600 text-sm">Add and edit departments</p>
                    </div>
                </a>
                
                <a href="#" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                    <i class="fas fa-chart-bar text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Analytics</h3>
                        <p class="text-gray-600 text-sm">View system reports</p>
                    </div>
                </a>
            </div>
        </div>

    @else
        <!-- Department Dashboard -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-inbox text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Assigned to Me</p>
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
                        <p class="text-sm text-gray-600">In Progress</p>
                        <p class="text-2xl font-semibold">{{ $complaints->where('status', 'in-progress')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Resolved</p>
                        <p class="text-2xl font-semibold">{{ $complaints->where('status', 'resolved')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Department Actions</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('department.complaints') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                    <i class="fas fa-tasks text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">My Complaints</h3>
                        <p class="text-gray-600 text-sm">View assigned complaints</p>
                    </div>
                </a>
                
                <a href="#" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                    <i class="fas fa-chart-pie text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Performance</h3>
                        <p class="text-gray-600 text-sm">View department stats</p>
                    </div>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection