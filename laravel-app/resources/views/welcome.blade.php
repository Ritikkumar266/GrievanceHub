@extends('layouts.app')

@section('title', 'ComplaintHub - Your Voice Matters')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 text-white overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0">
        <!-- Building Silhouettes -->
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent opacity-20"></div>
        
        <!-- Floating Service Icons -->
        <div class="absolute top-20 left-10 text-white opacity-10">
            <i class="fas fa-landmark text-6xl"></i>
        </div>
        <div class="absolute top-40 right-20 text-white opacity-10">
            <i class="fas fa-balance-scale text-5xl"></i>
        </div>
        <div class="absolute bottom-40 left-1/4 text-white opacity-10">
            <i class="fas fa-gavel text-4xl"></i>
        </div>
        <div class="absolute bottom-20 right-1/4 text-white opacity-10">
            <i class="fas fa-shield-alt text-5xl"></i>
        </div>
        
        <!-- Geometric Patterns -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-white to-transparent rounded-full opacity-5 -translate-y-48 translate-x-48"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-white to-transparent rounded-full opacity-5 translate-y-48 -translate-x-48"></div>
        
        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="grid grid-cols-12 h-full">
                @for($i = 0; $i < 12; $i++)
                    <div class="border-r border-white"></div>
                @endfor
            </div>
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 py-24">
        <div class="text-center">
            <!-- Logo & Branding -->
            <div class="flex items-center justify-center mb-8">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mr-4 shadow-2xl">
                    <i class="fas fa-clipboard-list text-blue-600 text-3xl"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-4xl font-bold">ComplaintHub</h1>
                    <p class="text-blue-100 text-lg">Grievance Portal</p>
                </div>
            </div>

            <!-- Main Headline -->
            <h2 class="text-6xl font-bold mb-6 leading-tight">
                Your Voice <span class="text-yellow-300">Matters</span>
            </h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto leading-relaxed text-blue-100">
                A transparent, efficient platform connecting citizens with service departments 
                to resolve complaints, improve public services, and build a better community together.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                @auth
                    <a href="/dashboard" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </a>
                @endauth
            </div>

            <!-- Trust Indicators -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300">{{ App\Models\Complaint::count() }}+</div>
                    <div class="text-blue-100 text-sm">Complaints Handled</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300">{{ App\Models\Department::count() }}</div>
                    <div class="text-blue-100 text-sm">Service Departments</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300">{{ App\Models\User::where('role', 'citizen')->count() }}+</div>
                    <div class="text-blue-100 text-sm">Active Citizens</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300">
                        @php
                            $totalComplaints = App\Models\Complaint::count();
                            $resolvedComplaints = App\Models\Complaint::where('status', 'resolved')->count();
                            $resolutionRate = $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100) : 95;
                        @endphp
                        {{ $resolutionRate }}%
                    </div>
                    <div class="text-blue-100 text-sm">Resolution Rate</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-white relative">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-32 h-32 border-2 border-blue-200 rounded-full"></div>
        <div class="absolute top-20 right-20 w-24 h-24 border-2 border-indigo-200 rounded-lg rotate-45"></div>
        <div class="absolute bottom-20 left-20 w-20 h-20 border-2 border-purple-200 rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">How ComplaintHub Works</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Simple, transparent, and efficient complaint resolution process designed for modern governance
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition duration-300 transform group-hover:-translate-y-2">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 bg-yellow-400 text-yellow-900 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">1</div>
                </div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Submit Complaint</h3>
                <p class="text-gray-600 leading-relaxed">
                    Easily submit your complaint with detailed description, category selection, and priority level. 
                    Our system automatically routes it to the relevant department.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition duration-300 transform group-hover:-translate-y-2">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 bg-yellow-400 text-yellow-900 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                </div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Track Progress</h3>
                <p class="text-gray-600 leading-relaxed">
                    Monitor your complaint status in real-time with detailed progress updates, 
                    department responses, and estimated resolution timelines.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition duration-300 transform group-hover:-translate-y-2">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 bg-yellow-400 text-yellow-900 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                </div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Get Resolution</h3>
                <p class="text-gray-600 leading-relaxed">
                    Receive timely resolution with complete transparency. Provide feedback 
                    on service quality to help improve public services.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Benefits Section -->
<div class="py-20 bg-gradient-to-r from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Why Choose ComplaintHub?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Built for transparency, efficiency, and citizen satisfaction
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-rocket text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Fast Resolution</h3>
                <p class="text-gray-600 text-sm">Automatic assignment to relevant departments for quick processing</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-eye text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Full Transparency</h3>
                <p class="text-gray-600 text-sm">Real-time tracking with complete visibility into resolution process</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-shield-check text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Secure & Private</h3>
                <p class="text-gray-600 text-sm">Your data is protected with enterprise-grade security measures</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Community Driven</h3>
                <p class="text-gray-600 text-sm">Feedback system helps improve services for everyone</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-20 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-transparent via-white to-transparent opacity-5"></div>
        <div class="absolute top-10 right-10 text-white opacity-10">
            <i class="fas fa-star text-4xl"></i>
        </div>
        <div class="absolute bottom-10 left-10 text-white opacity-10">
            <i class="fas fa-heart text-4xl"></i>
        </div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Ready to Make Your Voice Heard?</h2>
        <p class="text-xl mb-8 text-blue-100">
            Join thousands of citizens who trust ComplaintHub to resolve their concerns 
            and improve public services for everyone.
        </p>
        
        @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-user-plus mr-2"></i>Create Account Now
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </a>
            </div>
        @else
            <a href="/dashboard" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
            </a>
        @endguest
        
        <div class="mt-12 text-center">
            <p class="text-blue-100 text-sm">
                © 2026 ComplaintHub - Grievance Portal<br>
                Empowering citizens through transparent service delivery
            </p>
        </div>
    </div>
</div>
@endsection