@extends('layouts.app')

@section('title', 'Submit Complaint - ComplaintHub')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/30 to-purple-600/30"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce-subtle"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full animate-bounce-subtle" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-bounce-subtle" style="animation-delay: 1s;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white">
            <div class="animate-fade-in">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl flex items-center justify-center shadow-2xl mr-4">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        Submit New 
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Complaint
                        </span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    📝 Your voice matters. Submit your complaint and we'll ensure it reaches the right department for swift resolution.
                </p>
                
                <!-- Progress Indicator -->
                <div class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                    <span class="text-white font-semibold">Step 1: Submit Complaint</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 -mt-8 relative z-10">
    <!-- Main Form Container -->
    <div class="glass-effect rounded-3xl p-8 md:p-12 border border-white/20 shadow-2xl animate-fade-in">
        <!-- Form Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Complaint Details</h2>
                    <p class="text-gray-600 text-sm">Fill out the form below to submit your complaint</p>
                </div>
            </div>
            <a href="/dashboard" class="group flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-300">
                <i class="fas fa-arrow-left text-gray-600 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span class="text-gray-700 font-medium">Back</span>
            </a>
        </div>

        <form method="POST" action="{{ route('complaints.store') }}" class="space-y-8">
            @csrf

            <!-- Form Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between text-sm font-medium text-gray-600 mb-2">
                    <span>Form Progress</span>
                    <span id="progress-text">0% Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Title Field -->
            <div class="group">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-heading text-white text-sm"></i>
                        </div>
                        <span>Complaint Title</span>
                        <span class="text-red-500 ml-1">*</span>
                    </div>
                </label>
                <div class="relative">
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-4 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-gray-300"
                           placeholder="Brief, descriptive title for your complaint">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                        <i class="fas fa-check text-green-500 opacity-0 transition-opacity duration-300" id="title-check"></i>
                    </div>
                </div>
                @error('title')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Keep it concise but descriptive (e.g., "Water leakage on Main Street")
                </p>
            </div>

            <!-- Category Field -->
            <div class="group">
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-tags text-white text-sm"></i>
                        </div>
                        <span>Category</span>
                        <span class="text-red-500 ml-1">*</span>
                    </div>
                </label>
                <div class="relative">
                    <select id="category" name="category" required
                            class="w-full px-4 py-4 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 group-hover:border-gray-300 appearance-none">
                        <option value="">Select the most relevant category</option>
                        <option value="Water Supply" {{ old('category') == 'Water Supply' ? 'selected' : '' }}>
                            💧 Water Supply - Leaks, shortage, quality issues
                        </option>
                        <option value="Electricity" {{ old('category') == 'Electricity' ? 'selected' : '' }}>
                            ⚡ Electricity - Power outages, faulty connections
                        </option>
                        <option value="Road Maintenance" {{ old('category') == 'Road Maintenance' ? 'selected' : '' }}>
                            🛣️ Road Maintenance - Potholes, damaged roads
                        </option>
                        <option value="Waste Management" {{ old('category') == 'Waste Management' ? 'selected' : '' }}>
                            🗑️ Waste Management - Collection, disposal issues
                        </option>
                        <option value="Public Transport" {{ old('category') == 'Public Transport' ? 'selected' : '' }}>
                            🚌 Public Transport - Bus, metro service issues
                        </option>
                        <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>
                            🏥 Healthcare - Hospital, clinic service issues
                        </option>
                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>
                            🎓 Education - School, college related issues
                        </option>
                        <option value="Public Safety" {{ old('category') == 'Public Safety' ? 'selected' : '' }}>
                            🛡️ Public Safety - Security, law enforcement
                        </option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>
                            📋 Other - General administrative issues
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('category')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
                <div id="category-info" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-xl hidden">
                    <p class="text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span id="category-description"></span>
                    </p>
                </div>
            </div>

            <!-- Address Field -->
            <div class="group">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt text-white text-sm"></i>
                        </div>
                        <span>Address/Location</span>
                        <span class="text-red-500 ml-1">*</span>
                    </div>
                </label>
                <div class="relative">
                    <textarea id="address" name="address" rows="3" required
                              class="w-full px-4 py-4 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 group-hover:border-gray-300 resize-none"
                              placeholder="Please provide the complete address where the issue is located:&#10;• Street address, building number&#10;• Area/locality name&#10;• City, state, postal code&#10;• Nearby landmarks (if applicable)">{{ old('address') }}</textarea>
                    <div class="absolute bottom-4 right-4 text-xs text-gray-400">
                        <span id="address-char-count">0</span>/500 characters
                    </div>
                </div>
                @error('address')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Provide the exact location where the issue occurred for faster resolution
                </p>
            </div>

            <!-- Priority Field -->
            <div class="group">
                <label for="priority" class="block text-sm font-semibold text-gray-700 mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <span>Priority Level</span>
                        <span class="text-red-500 ml-1">*</span>
                    </div>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="low" {{ old('priority') == 'low' ? 'checked' : '' }} class="sr-only peer" required>
                        <div class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 peer-checked:bg-green-500 rounded-xl flex items-center justify-center mr-3 transition-colors duration-300">
                                    <i class="fas fa-leaf text-green-600 peer-checked:text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Low Priority</h4>
                                    <p class="text-sm text-gray-600">Minor issue, not urgent</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="medium" {{ old('priority') == 'medium' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:border-gray-300 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 peer-checked:bg-yellow-500 rounded-xl flex items-center justify-center mr-3 transition-colors duration-300">
                                    <i class="fas fa-clock text-yellow-600 peer-checked:text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Medium Priority</h4>
                                    <p class="text-sm text-gray-600">Needs attention soon</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-gray-300 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 peer-checked:bg-orange-500 rounded-xl flex items-center justify-center mr-3 transition-colors duration-300">
                                    <i class="fas fa-exclamation text-orange-600 peer-checked:text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">High Priority</h4>
                                    <p class="text-sm text-gray-600">Important, prompt action needed</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="urgent" {{ old('priority') == 'urgent' ? 'checked' : '' }} class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 peer-checked:bg-red-500 rounded-xl flex items-center justify-center mr-3 transition-colors duration-300">
                                    <i class="fas fa-fire text-red-600 peer-checked:text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Urgent</h4>
                                    <p class="text-sm text-gray-600">Critical, immediate action required</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('priority')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="group">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-align-left text-white text-sm"></i>
                        </div>
                        <span>Detailed Description</span>
                        <span class="text-red-500 ml-1">*</span>
                    </div>
                </label>
                <div class="relative">
                    <textarea id="description" name="description" rows="6" required
                              class="w-full px-4 py-4 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300 group-hover:border-gray-300 resize-none"
                              placeholder="Please provide a detailed description of your complaint. Include:&#10;• What happened?&#10;• When did it occur?&#10;• Where did it happen? (specific location)&#10;• Any previous attempts to resolve this?&#10;• Any reference numbers or contact details">{{ old('description') }}</textarea>
                    <div class="absolute bottom-4 right-4 text-xs text-gray-400">
                        <span id="char-count">0</span>/1000 characters
                    </div>
                </div>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Guidelines Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-blue-800 mb-3">💡 Tips for Effective Complaints</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Be specific about location and time</span>
                                </div>
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Provide complete address with landmarks</span>
                                </div>
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Include reference numbers if available</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Use respectful, professional language</span>
                                </div>
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Provide contact details for follow-up</span>
                                </div>
                                <div class="flex items-center text-sm text-blue-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Mention nearby landmarks for easy location</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-200">
                <a href="/dashboard" 
                   class="group flex items-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 font-medium">
                    <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                    Cancel & Go Back
                </a>
                
                <button type="submit" 
                        class="group flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold">
                    <i class="fas fa-paper-plane mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                    Submit Complaint
                </button>
            </div>
        </form>
    </div>

    <!-- What Happens Next Section -->
    <div class="glass-effect rounded-2xl p-8 mt-8 border border-white/20 shadow-xl animate-fade-in" style="animation-delay: 0.2s;">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-route text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                What Happens Next?
            </h3>
            <p class="text-gray-600">Your complaint journey in 3 simple steps</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="relative mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-search text-white"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-yellow-900">1</div>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Automatic Assignment</h4>
                <p class="text-sm text-gray-600">Your complaint is automatically routed to the relevant department based on category</p>
            </div>
            
            <div class="text-center">
                <div class="relative mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-yellow-900">2</div>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Processing & Updates</h4>
                <p class="text-sm text-gray-600">Department reviews and processes your complaint with regular status updates</p>
            </div>
            
            <div class="text-center">
                <div class="relative mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-yellow-900">3</div>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Resolution & Feedback</h4>
                <p class="text-sm text-gray-600">Receive resolution notification and provide feedback on service quality</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form progress tracking
    const form = document.querySelector('form');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const requiredFields = form.querySelectorAll('[required]');
    
    function updateProgress() {
        let filledFields = 0;
        requiredFields.forEach(field => {
            if (field.type === 'radio') {
                if (form.querySelector(`input[name="${field.name}"]:checked`)) {
                    filledFields++;
                }
            } else if (field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progress = requiredFields.length > 0 ? Math.round((filledFields / requiredFields.length) * 100) : 0;
        progressBar.style.width = progress + '%';
        progressText.textContent = progress + '% Complete';
        
        if (progress === 100) {
            progressBar.classList.add('bg-gradient-to-r', 'from-green-500', 'to-emerald-600');
            progressBar.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600');
        }
    }
    
    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('char-count');
    
    description.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count;
        
        if (count > 800) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });
    
    // Character counter for address
    const address = document.getElementById('address');
    const addressCharCount = document.getElementById('address-char-count');
    
    address.addEventListener('input', function() {
        const count = this.value.length;
        addressCharCount.textContent = count;
        
        if (count > 450) {
            addressCharCount.classList.add('text-red-500');
        } else {
            addressCharCount.classList.remove('text-red-500');
        }
        updateProgress();
    });
    
    // Category information display
    const categorySelect = document.getElementById('category');
    const categoryInfo = document.getElementById('category-info');
    const categoryDescription = document.getElementById('category-description');
    
    const categoryDescriptions = {
        'Water Supply': 'This will be assigned to the Water Supply Department for issues related to water distribution, quality, and infrastructure.',
        'Electricity': 'This will be assigned to the Electricity Department for power-related issues and electrical infrastructure.',
        'Road Maintenance': 'This will be assigned to the Public Works Department for road repairs and maintenance issues.',
        'Waste Management': 'This will be assigned to the Sanitation Department for waste collection and disposal issues.',
        'Public Transport': 'This will be assigned to the Transport Department for public transportation service issues.',
        'Healthcare': 'This will be assigned to the Health Department for healthcare facility and service issues.',
        'Education': 'This will be assigned to the Education Department for school and educational institution issues.',
        'Public Safety': 'This will be assigned to the Police Department for security and law enforcement issues.',
        'Other': 'This will be assigned to the General Administration for miscellaneous issues.'
    };
    
    categorySelect.addEventListener('change', function() {
        if (this.value && categoryDescriptions[this.value]) {
            categoryDescription.textContent = categoryDescriptions[this.value];
            categoryInfo.classList.remove('hidden');
        } else {
            categoryInfo.classList.add('hidden');
        }
        updateProgress();
    });
    
    // Title validation
    const titleInput = document.getElementById('title');
    const titleCheck = document.getElementById('title-check');
    
    titleInput.addEventListener('input', function() {
        if (this.value.length >= 10) {
            titleCheck.classList.remove('opacity-0');
            titleCheck.classList.add('opacity-100');
        } else {
            titleCheck.classList.add('opacity-0');
            titleCheck.classList.remove('opacity-100');
        }
        updateProgress();
    });
    
    // Add event listeners for progress tracking
    requiredFields.forEach(field => {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });
    
    // Initial progress update
    updateProgress();
});
</script>
@endsection