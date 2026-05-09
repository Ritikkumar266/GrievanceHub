@extends('layouts.app')

@section('title', 'Register - ComplaintHub')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-indigo-50 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0">
        <!-- Government Building Silhouette -->
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-green-600 to-blue-600 opacity-10"></div>
        
        <!-- Floating Icons -->
        <div class="absolute top-20 left-10 text-green-200 opacity-30">
            <i class="fas fa-users text-4xl"></i>
        </div>
        <div class="absolute top-40 right-20 text-blue-200 opacity-30">
            <i class="fas fa-handshake text-3xl"></i>
        </div>
        <div class="absolute bottom-40 left-20 text-indigo-200 opacity-30">
            <i class="fas fa-clipboard-check text-3xl"></i>
        </div>
        <div class="absolute bottom-20 right-10 text-green-200 opacity-30">
            <i class="fas fa-user-shield text-4xl"></i>
        </div>
        
        <!-- Geometric Patterns -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-green-100 to-transparent rounded-full opacity-50 -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-100 to-transparent rounded-full opacity-50 translate-y-48 -translate-x-48"></div>
    </div>

    <div class="relative z-10 min-h-screen flex">
        <!-- Left Side - Branding & Information -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-600 via-blue-600 to-indigo-700 p-12 flex-col justify-center relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white rounded-full"></div>
                <div class="absolute top-32 right-20 w-16 h-16 border-2 border-white rounded-lg rotate-45"></div>
                <div class="absolute bottom-32 left-20 w-12 h-12 border-2 border-white rounded-full"></div>
                <div class="absolute bottom-10 right-10 w-24 h-24 border-2 border-white rounded-lg rotate-12"></div>
            </div>
            
            <div class="relative z-10">
                <!-- Logo & Title -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Join ComplaintHub</h1>
                            <p class="text-green-100">Become Part of the Solution</p>
                        </div>
                    </div>
                </div>

                <!-- Mission Statement -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-white mb-4">Empower Your Voice</h2>
                    <p class="text-green-100 text-lg leading-relaxed mb-6">
                        Join thousands of citizens making a difference. Register today to submit complaints, 
                        track progress, and help improve government services for everyone.
                    </p>
                </div>

                <!-- Registration Benefits -->
                <div class="space-y-4">
                    <div class="flex items-center text-white">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-paper-plane text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Submit Complaints</h3>
                            <p class="text-green-100 text-sm">Report issues directly to relevant departments</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-white">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Track Progress</h3>
                            <p class="text-green-100 text-sm">Monitor resolution status in real-time</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-white">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-comments text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Provide Feedback</h3>
                            <p class="text-green-100 text-sm">Rate services and help improve quality</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-white">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-history text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Access History</h3>
                            <p class="text-green-100 text-sm">View all your past complaints and resolutions</p>
                        </div>
                    </div>
                </div>

                <!-- Community Stats -->
                <div class="mt-12 grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ App\Models\User::where('role', 'citizen')->count() }}+</div>
                        <div class="text-green-100 text-sm">Active Citizens</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ App\Models\Complaint::where('status', 'resolved')->count() }}+</div>
                        <div class="text-green-100 text-sm">Issues Resolved</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="max-w-md w-full">
                <!-- Mobile Logo (visible on small screens) -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl font-bold text-gray-900">ComplaintHub</h1>
                            <p class="text-gray-600 text-sm">Join the Community</p>
                        </div>
                    </div>
                </div>

                <!-- Registration Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full mb-4 shadow-lg">
                            <i class="fas fa-user-plus text-white text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
                        <p class="text-gray-600">Join ComplaintHub community today</p>
                    </div>

                    <!-- Account Types Info -->
                    <div class="mb-6">
                        <div class="grid grid-cols-1 gap-2 text-xs">
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-green-600 mr-2"></i>
                                    <div>
                                        <div class="font-semibold text-green-700">Citizen Account</div>
                                        <div class="text-green-600">Submit complaints, track progress, provide feedback</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Full Name
                            </label>
                            <input id="name" name="name" type="text" autocomplete="name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white" 
                                   placeholder="Enter your full name" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                            </label>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white" 
                                   placeholder="Enter your email address" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-badge mr-2 text-gray-400"></i>Account Type
                            </label>
                            <select id="role" name="role" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Select account type</option>
                                <option value="citizen" {{ old('role') == 'citizen' ? 'selected' : '' }}>👤 Citizen</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                                <option value="department" {{ old('role') == 'department' ? 'selected' : '' }}>🏢 Department</option>
                            </select>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                            </label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white" 
                                   placeholder="Create a secure password">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Confirm Password
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white" 
                                   placeholder="Confirm your password">
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <div>
                                        @foreach ($errors->all() as $error)
                                            <p class="text-sm">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create ComplaintHub Account
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:text-green-700 transition duration-200">
                                Sign In
                            </a>
                        </p>
                    </div>

                    <!-- Terms & Privacy -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 text-center">
                            By creating an account, you agree to our 
                            <a href="#" class="text-green-600 hover:text-green-700">Terms of Service</a> 
                            and 
                            <a href="#" class="text-green-600 hover:text-green-700">Privacy Policy</a>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-gray-500 text-sm">
                    <p>© 2026 ComplaintHub - Government Grievance Portal</p>
                    <p class="mt-1">Empowering citizens through transparent governance</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection