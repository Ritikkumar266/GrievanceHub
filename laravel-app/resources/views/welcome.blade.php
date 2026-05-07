@extends('layouts.app')

@section('title', 'ComplaintHub - Your Voice Matters')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6">Your Voice Matters</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Submit complaints, track progress, and get resolutions faster with our comprehensive complaint management system.
            </p>
            <div class="space-x-4">
                @auth
                    <a href="/dashboard" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">How It Works</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Simple, transparent, and efficient complaint resolution process</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-edit text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Submit Complaint</h3>
                <p class="text-gray-600">Easily submit your complaint with detailed description and category selection.</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cogs text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Track Progress</h3>
                <p class="text-gray-600">Monitor your complaint status in real-time with detailed progress updates.</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Get Resolution</h3>
                <p class="text-gray-600">Receive timely resolution and provide feedback on the service quality.</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-bold text-blue-600 mb-2">1000+</div>
                <div class="text-gray-600">Complaints Resolved</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-green-600 mb-2">95%</div>
                <div class="text-gray-600">Satisfaction Rate</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-600 mb-2">24/7</div>
                <div class="text-gray-600">Support Available</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-orange-600 mb-2">48hrs</div>
                <div class="text-gray-600">Average Response</div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8">Join thousands of users who trust us with their complaints and feedback.</p>
        @guest
            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Create Account Now
            </a>
        @endguest
    </div>
</div>
@endsection