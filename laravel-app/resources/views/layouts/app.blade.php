<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ComplaintHub - Grievance Portal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-subtle': 'bounceSubtle 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        bounceSubtle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* ===== Animated Particles Canvas ===== */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== Theme Toggle Button ===== */
        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }
        .theme-toggle:hover {
            transform: scale(1.15) rotate(20deg);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.5);
        }

        /* ===== Light Theme (default) ===== */
        body.light-theme {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 30%, #ddd6fe 60%, #ede9fe 100%);
        }
        .light-theme .glass-effect {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.35);
        }
        .light-theme nav {
            background: rgba(255,255,255,0.85) !important;
        }

        /* ===== Dark Theme ===== */
        body.dark-theme {
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 30%, #16213e 60%, #0f0c29 100%);
        }
        .dark-theme .glass-effect {
            background: rgba(30, 30, 60, 0.55);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dark-theme nav {
            background: rgba(15, 12, 41, 0.9) !important;
            border-color: rgba(255,255,255,0.06) !important;
        }
        .dark-theme nav span, .dark-theme nav p, .dark-theme nav a, .dark-theme nav button {
            color: #c7d2fe !important;
        }
        .dark-theme nav .bg-gradient-to-r.from-gray-50 {
            background: rgba(30,30,60,0.6) !important;
            border-color: rgba(255,255,255,0.1) !important;
        }

        /* ===== Dark Theme: Text Visibility Fix ===== */
        .dark-theme .text-gray-600, .dark-theme .text-gray-500,
        .dark-theme .text-gray-700, .dark-theme .text-gray-800,
        .dark-theme .text-gray-900, .dark-theme .text-gray-400 {
            color: #c7d2fe !important;
        }
        .dark-theme .text-gray-300 {
            color: #a5b4fc !important;
        }
        .dark-theme h1, .dark-theme h2, .dark-theme h3, .dark-theme h4, .dark-theme h5, .dark-theme h6 {
            color: #e0e7ff !important;
            -webkit-text-fill-color: unset !important;
        }
        .dark-theme p, .dark-theme span, .dark-theme label, .dark-theme td, .dark-theme th {
            color: #c7d2fe;
        }
        .dark-theme .bg-gradient-to-r.from-gray-800.to-gray-600 {
            background: none !important;
            -webkit-text-fill-color: #e0e7ff !important;
        }
        .dark-theme .border-gray-200, .dark-theme .border-gray-100, .dark-theme .border-gray-300 {
            border-color: rgba(255,255,255,0.10) !important;
        }
        .dark-theme .bg-white, .dark-theme .bg-gray-50, .dark-theme .bg-gradient-to-r.from-gray-50 {
            background: rgba(30,30,60,0.4) !important;
        }
        .dark-theme .from-blue-50, .dark-theme .from-green-50, .dark-theme .from-purple-50,
        .dark-theme .from-yellow-50, .dark-theme .from-orange-50, .dark-theme .from-red-50 {
            --tw-gradient-from: rgba(30,30,60,0.3) !important;
        }

        /* ===== Dark Theme: Homepage Sections ===== */
        /* Hero Section - deeper dark gradient */
        .dark-theme .bg-gradient-to-br.from-blue-600 {
            background: linear-gradient(to bottom right, #1a1040, #0f1a3e, #1a0f3d) !important;
        }

        /* Features Section ("How ComplaintHub Works") */
        .dark-theme #features-section {
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #16213e 100%) !important;
        }
        .dark-theme #features-section .text-gray-800,
        .dark-theme #features-section h2,
        .dark-theme #features-section h3 {
            color: #e0e7ff !important;
        }
        .dark-theme #features-section .text-gray-600,
        .dark-theme #features-section p {
            color: #a5b4fc !important;
        }

        /* Benefits Section ("Why Choose ComplaintHub?") */
        .dark-theme #benefits-section {
            background: linear-gradient(135deg, #0f0c29 0%, #16213e 50%, #1a1a2e 100%) !important;
        }
        .dark-theme #benefits-section .bg-white {
            background: rgba(30, 30, 60, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dark-theme #benefits-section .text-gray-800,
        .dark-theme #benefits-section h2,
        .dark-theme #benefits-section h3 {
            color: #e0e7ff !important;
        }
        .dark-theme #benefits-section .text-gray-600,
        .dark-theme #benefits-section p {
            color: #a5b4fc !important;
        }

        /* CTA Section */
        .dark-theme #cta-section {
            background: linear-gradient(to right, #1a0f3d, #0f1a3e, #2d1b69) !important;
        }

        /* ===== Dark Theme: Auth Pages (Login/Register) ===== */
        .dark-theme .bg-gradient-to-br.from-blue-50,
        .dark-theme .min-h-screen.bg-gradient-to-br {
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 50%, #16213e 100%) !important;
        }
        .dark-theme .bg-blue-50 {
            background: rgba(59, 130, 246, 0.1) !important;
        }
        .dark-theme .text-blue-700 {
            color: #93c5fd !important;
        }
        .dark-theme .text-blue-600 {
            color: #60a5fa !important;
        }
        .dark-theme .text-red-700 {
            color: #fca5a5 !important;
        }
        .dark-theme .bg-red-50 {
            background: rgba(220, 38, 38, 0.1) !important;
        }
        .dark-theme .border-blue-100 {
            border-color: rgba(59, 130, 246, 0.2) !important;
        }
        .dark-theme .border-red-200 {
            border-color: rgba(220, 38, 38, 0.2) !important;
        }
        .dark-theme .bg-green-50 {
            background: rgba(16, 185, 129, 0.1) !important;
        }
        .dark-theme .text-green-800 {
            color: #6ee7b7 !important;
        }
        .dark-theme .border-green-200 {
            border-color: rgba(16, 185, 129, 0.2) !important;
        }

        /* ===== Dark Theme: Forms & Inputs ===== */
        .dark-theme input, .dark-theme textarea, .dark-theme select {
            background-color: rgba(30, 30, 60, 0.6) !important;
            color: #e0e7ff !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        .dark-theme input::placeholder, .dark-theme textarea::placeholder {
            color: rgba(167, 139, 250, 0.5) !important;
        }
        .dark-theme input:focus, .dark-theme textarea:focus, .dark-theme select:focus {
            background-color: rgba(30, 30, 60, 0.8) !important;
            border-color: rgba(139, 92, 246, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15) !important;
        }

        /* ===== Dark Theme: Dropdowns & Cards ===== */
        .dark-theme .bg-white\/95 {
            background: rgba(30, 30, 60, 0.95) !important;
        }
        .dark-theme .bg-blue-100 {
            background: rgba(59, 130, 246, 0.15) !important;
        }
        .dark-theme .text-blue-800 {
            color: #93c5fd !important;
        }

        /* ===== Dark Theme: Footer & Misc ===== */
        .dark-theme footer {
            background: linear-gradient(90deg, #0a0a1a, #111133, #0a0a1a) !important;
        }
        .dark-theme .text-red-600 { color: #fca5a5 !important; }
        .dark-theme .hover\:bg-red-50:hover { background: rgba(220,38,38,0.1) !important; }
        .dark-theme .hover\:bg-blue-50:hover { background: rgba(59,130,246,0.1) !important; }
        .dark-theme #loading-overlay { background: rgba(15,12,41,0.85) !important; }
        .dark-theme .theme-toggle {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #1a1a2e;
        }

        /* ===== Existing Styles ===== */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::before {
            width: 100%;
        }
        
        .status-badge {
            position: relative;
            overflow: hidden;
        }
        
        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .status-badge:hover::before {
            left: 100%;
        }

        /* Smooth theme transition */
        body, nav, .glass-effect, footer {
            transition: background 0.5s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* ===== Hero Floating Shape Animations ===== */
        .hero-float-shape {
            position: absolute;
            transition: opacity 0.5s ease;
        }

        @keyframes heroFloat1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -40px) rotate(10deg); }
            50% { transform: translate(-20px, -70px) rotate(-5deg); }
            75% { transform: translate(40px, -30px) rotate(8deg); }
        }
        @keyframes heroFloat2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-50px, 30px) scale(1.08); }
            66% { transform: translate(30px, -40px) scale(0.95); }
        }
        @keyframes heroFloat3 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-35px, -25px) rotate(15deg); }
            50% { transform: translate(25px, -55px) rotate(-10deg); }
            75% { transform: translate(-15px, 20px) rotate(5deg); }
        }
        @keyframes heroFloat4 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            30% { transform: translate(45px, 20px) rotate(-12deg); }
            60% { transform: translate(-30px, -35px) rotate(8deg); }
        }
        @keyframes heroFloat5 {
            0%, 100% { transform: translate(0, 0); }
            20% { transform: translate(20px, -50px); }
            40% { transform: translate(-40px, -20px); }
            60% { transform: translate(15px, 30px); }
            80% { transform: translate(-25px, -40px); }
        }
        @keyframes heroFloat6 {
            0%, 100% { transform: translate(0, 0) rotate(45deg); }
            25% { transform: translate(-30px, -20px) rotate(55deg); }
            50% { transform: translate(20px, -50px) rotate(35deg); }
            75% { transform: translate(-10px, 15px) rotate(50deg); }
        }

        /* ===== Dark Theme: Hero Section Override ===== */
        .dark-theme #hero-section {
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 40%, #16213e 70%, #1a0f3d 100%) !important;
        }
        .dark-theme #hero-section h1,
        .dark-theme #hero-section h2 {
            color: #e0e7ff !important;
        }
        .dark-theme #hero-section h2 span {
            color: #a78bfa !important;
        }
        .dark-theme #hero-section p {
            color: #a5b4fc !important;
        }
        .dark-theme #hero-section .text-indigo-900 {
            color: #e0e7ff !important;
        }
        .dark-theme #hero-section .text-indigo-500 {
            color: #818cf8 !important;
        }
        .dark-theme #hero-section .text-indigo-700 {
            color: #a5b4fc !important;
        }
        .dark-theme #hero-section .text-purple-700 {
            color: #c4b5fd !important;
        }
        .dark-theme #hero-section .text-indigo-600 {
            color: #818cf8 !important;
        }
        .dark-theme #hero-section .text-gray-900 {
            color: #e0e7ff !important;
        }
        .dark-theme #hero-section .bg-indigo-600 {
            background-color: #6366f1 !important;
        }
        .dark-theme #hero-section .border-indigo-600 {
            border-color: #818cf8 !important;
        }
        .dark-theme #hero-section .hero-float-shape {
            opacity: 0.7;
            filter: brightness(1.5);
        }
    </style>
</head>
<body class="light-theme min-h-screen font-sans">
    <!-- Animated Particles Background -->
    <canvas id="particles-canvas"></canvas>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="theme-icon"></i>
    </button>

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-clipboard-list text-white text-lg"></i>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full animate-bounce-subtle"></div>
                        </div>
                        <div>
                            <span class="font-bold text-xl bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">ComplaintHub</span>
                            <p class="text-xs text-gray-500 -mt-1">Grievance Portal</p>
                        </div>
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    @auth
                        <!-- Quick Actions -->
                        <div class="hidden md:flex items-center space-x-4">
                            @if(Auth::user()->role == 'citizen')
                                <a href="{{ route('complaints.create') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>New Complaint</span>
                                </a>
                                <a href="{{ route('complaints.my') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-list-alt"></i>
                                    <span>My Complaints</span>
                                </a>
                            @elseif(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.complaints') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>All Complaints</span>
                                </a>
                                <a href="{{ route('admin.feedback') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-star"></i>
                                    <span>Feedback</span>
                                </a>
                            @elseif(Auth::user()->role == 'department')
                                <a href="{{ route('department.complaints') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-tasks"></i>
                                    <span>My Tasks</span>
                                </a>
                                <a href="{{ route('department.feedback') }}" class="nav-link flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-star"></i>
                                    <span>Feedback</span>
                                </a>
                            @endif
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 px-4 py-2 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover ring-2 ring-white">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-inner">
                                        <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="text-left hidden sm:block">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit(Auth::user()->name, 15) }}</p>
                                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors duration-200"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200/50 py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1 capitalize">
                                        <i class="fas fa-circle text-xs mr-1"></i>{{ Auth::user()->role }}
                                    </span>
                                </div>
                                
                                <div class="py-2">
                                    <a href="/dashboard" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                        <i class="fas fa-tachometer-alt w-5 text-center mr-3 text-blue-500"></i>Dashboard
                                    </a>
                                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                        <i class="fas fa-user w-5 text-center mr-3 text-green-500"></i>My Profile
                                    </a>
                                    
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{ route('admin.departments') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                            <i class="fas fa-building w-5 text-center mr-3 text-purple-500"></i>Manage Departments
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="border-t border-gray-100 pt-2">
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="nav-link px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                Get Started
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-sm animate-slide-up">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-sm animate-slide-up">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">ComplaintHub</h3>
                            <p class="text-gray-400 text-sm">Grievance Portal</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Empowering citizens through transparent service delivery. Submit complaints, track progress, and help improve services for everyone.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors duration-200">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors duration-200">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200">Home</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Register</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Login</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Contact Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2026 ComplaintHub. Built by the team "Agile Avengers" for better governance.</p>
            </div>
        </div>
    </footer>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mb-4"></div>
            <p class="text-gray-600 font-medium">Loading...</p>
        </div>
    </div>

    <script>
        // ===== THEME TOGGLE =====
        function toggleTheme() {
            const body = document.body;
            const icon = document.getElementById('theme-icon');
            if (body.classList.contains('light-theme')) {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme');
                icon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-theme');
                body.classList.add('light-theme');
                icon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
            }
            // Reinit particles with new colors
            initParticles();
        }

        // Load saved theme
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark') {
                document.body.classList.remove('light-theme');
                document.body.classList.add('dark-theme');
                const icon = document.getElementById('theme-icon');
                if (icon) icon.className = 'fas fa-sun';
            }
        })();

        // ===== ANIMATED PARTICLES =====
        function initParticles() {
            const canvas = document.getElementById('particles-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];
            let animId;
            const isDark = document.body.classList.contains('dark-theme');

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            // Particle shapes: circles, triangles, squares, hexagons, stars
            const shapes = ['circle', 'triangle', 'square', 'hexagon', 'star'];
            const lightColors = [
                'rgba(99,102,241,0.40)', 'rgba(139,92,246,0.35)',
                'rgba(59,130,246,0.38)', 'rgba(236,72,153,0.30)',
                'rgba(16,185,129,0.28)', 'rgba(245,158,11,0.30)',
                'rgba(168,85,247,0.32)', 'rgba(34,211,238,0.28)'
            ];
            const darkColors = [
                'rgba(99,102,241,0.55)', 'rgba(139,92,246,0.50)',
                'rgba(59,130,246,0.48)', 'rgba(236,72,153,0.42)',
                'rgba(16,185,129,0.40)', 'rgba(245,158,11,0.38)',
                'rgba(168,85,247,0.45)', 'rgba(34,211,238,0.42)'
            ];
            const colors = isDark ? darkColors : lightColors;

            // Create more particles for a richer effect
            const count = Math.min(55, Math.floor(window.innerWidth / 25));
            particles = [];
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 30 + 12,
                    speedX: (Math.random() - 0.5) * 1.8,
                    speedY: (Math.random() - 0.5) * 1.4,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    shape: shapes[Math.floor(Math.random() * shapes.length)],
                    rotation: Math.random() * Math.PI * 2,
                    rotSpeed: (Math.random() - 0.5) * 0.04,
                    opacity: Math.random() * 0.5 + 0.5,
                    pulse: Math.random() * Math.PI * 2,
                    drift: Math.random() * 0.005 + 0.002
                });
            }

            function drawShape(p) {
                ctx.save();
                ctx.translate(p.x, p.y);
                ctx.rotate(p.rotation);
                ctx.globalAlpha = p.opacity * (0.6 + 0.4 * Math.sin(p.pulse));
                ctx.fillStyle = p.color;
                // Add a soft glow effect
                ctx.shadowColor = p.color;
                ctx.shadowBlur = p.size * 0.6;
                ctx.beginPath();
                const s = p.size;
                switch(p.shape) {
                    case 'circle':
                        ctx.arc(0, 0, s / 2, 0, Math.PI * 2);
                        break;
                    case 'triangle':
                        ctx.moveTo(0, -s / 2);
                        ctx.lineTo(s / 2, s / 2);
                        ctx.lineTo(-s / 2, s / 2);
                        ctx.closePath();
                        break;
                    case 'square':
                        ctx.rect(-s / 2, -s / 2, s, s);
                        break;
                    case 'hexagon':
                        for (let i = 0; i < 6; i++) {
                            const angle = (Math.PI / 3) * i;
                            const hx = (s / 2) * Math.cos(angle);
                            const hy = (s / 2) * Math.sin(angle);
                            i === 0 ? ctx.moveTo(hx, hy) : ctx.lineTo(hx, hy);
                        }
                        ctx.closePath();
                        break;
                    case 'star':
                        for (let i = 0; i < 5; i++) {
                            const outerAngle = (Math.PI * 2 / 5) * i - Math.PI / 2;
                            const innerAngle = outerAngle + Math.PI / 5;
                            const ox = (s / 2) * Math.cos(outerAngle);
                            const oy = (s / 2) * Math.sin(outerAngle);
                            const ix = (s / 4.5) * Math.cos(innerAngle);
                            const iy = (s / 4.5) * Math.sin(innerAngle);
                            i === 0 ? ctx.moveTo(ox, oy) : ctx.lineTo(ox, oy);
                            ctx.lineTo(ix, iy);
                        }
                        ctx.closePath();
                        break;
                }
                ctx.fill();
                ctx.restore();
            }

            function connectParticles() {
                const maxDist = 220;
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < maxDist) {
                            const alpha = (1 - dist / maxDist);
                            ctx.beginPath();
                            ctx.strokeStyle = isDark
                                ? 'rgba(139,92,246,' + (0.25 * alpha) + ')'
                                : 'rgba(99,102,241,' + (0.18 * alpha) + ')';
                            ctx.lineWidth = 1.2 * alpha;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
            }

            if (animId) cancelAnimationFrame(animId);
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    // Add gentle sine-wave drift for organic movement
                    p.x += p.speedX + Math.sin(p.pulse * 0.5) * 0.3;
                    p.y += p.speedY + Math.cos(p.pulse * 0.4) * 0.2;
                    p.rotation += p.rotSpeed;
                    p.pulse += 0.04;
                    // Wrap around
                    if (p.x < -30) p.x = canvas.width + 30;
                    if (p.x > canvas.width + 30) p.x = -30;
                    if (p.y < -30) p.y = canvas.height + 30;
                    if (p.y > canvas.height + 30) p.y = -30;
                    drawShape(p);
                });
                connectParticles();
                animId = requestAnimationFrame(animate);
            }
            animate();
        }

        // ===== LOADING & ALERTS =====
        document.addEventListener('DOMContentLoaded', function() {
            initParticles();

            const links = document.querySelectorAll('a[href^="/"], button[type="submit"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.hasAttribute('data-no-loading')) {
                        setTimeout(() => {
                            document.getElementById('loading-overlay').classList.remove('hidden');
                        }, 100);
                    }
                });
            });

            const alerts = document.querySelectorAll('.animate-slide-up');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>