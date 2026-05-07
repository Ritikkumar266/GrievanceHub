@extends('layouts.app')

@section('title', 'My Profile - ComplaintHub')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 px-6 py-8">
            <div class="flex items-center space-x-6">
                <div class="relative">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-blue-600 text-3xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="text-white">
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-blue-100 text-lg capitalize">{{ $user->role }}</p>
                    <p class="text-blue-100">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="flex space-x-4">
                <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit Profile
                </a>
                <button onclick="document.getElementById('pictureModal').classList.remove('hidden')" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-camera mr-2"></i>Change Picture
                </button>
                <button onclick="document.getElementById('passwordModal').classList.remove('hidden')" 
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-lock mr-2"></i>Change Password
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-user text-blue-600 mr-2"></i>Personal Information
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Full Name</label>
                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Email Address</label>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                    <p class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Address</label>
                    <p class="text-gray-900">{{ $user->address ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-cog text-green-600 mr-2"></i>Account Information
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Account Type</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($user->role == 'admin') bg-red-100 text-red-800
                        @elseif($user->role == 'department') bg-blue-100 text-blue-800
                        @else bg-green-100 text-green-800 @endif">
                        <i class="fas fa-circle text-xs mr-2"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Member Since</label>
                    <p class="text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                    <p class="text-gray-900">{{ $user->updated_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Picture Modal -->
<div id="pictureModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Profile Picture</h3>
            
            <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Choose New Picture</label>
                    <input type="file" name="profile_picture" accept="image/*" required
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</p>
                </div>
                
                <div class="flex justify-between">
                    <button type="button" onclick="document.getElementById('pictureModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Upload Picture
                    </button>
                </div>
            </form>
            
            @if($user->profile_picture)
                <div class="mt-4 pt-4 border-t">
                    <form action="{{ route('profile.picture.delete') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                onclick="return confirm('Are you sure you want to remove your profile picture?')">
                            <i class="fas fa-trash mr-1"></i>Remove Current Picture
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="passwordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
            
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="document.getElementById('passwordModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection