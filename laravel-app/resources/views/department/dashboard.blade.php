@extends('layouts.app')

@section('title', 'Department Dashboard - ComplaintHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Department Dashboard</h1>
        <p class="text-gray-600 mt-2">
            Welcome, {{ Auth::user()->name }}! 
            @if(Auth::user()->department)
                Manage complaints for {{ Auth::user()->department->name }}.
            @endif
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-inbox text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Assigned to Me</p>
                    <p class="text-2xl font-semibold">{{ $assignedComplaints ?? 0 }}</p>
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
                    <p class="text-2xl font-semibold">{{ $pendingComplaints ?? 0 }}</p>
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
                    <p class="text-2xl font-semibold">{{ $resolvedComplaints ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Department Actions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('department.complaints') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                <i class="fas fa-tasks text-blue-600 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-semibold">My Complaints</h3>
                    <p class="text-gray-600 text-sm">View and manage assigned complaints</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                <i class="fas fa-chart-pie text-green-600 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-semibold">Performance</h3>
                    <p class="text-gray-600 text-sm">View department statistics</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection