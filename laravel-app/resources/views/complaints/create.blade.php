@extends('layouts.app')

@section('title', 'Submit Complaint - ComplaintHub')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Submit New Complaint</h1>
            <a href="/dashboard" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>

        <form method="POST" action="{{ route('complaints.store') }}">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading text-gray-400 mr-2"></i>Complaint Title *
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Brief description of your complaint">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tags text-gray-400 mr-2"></i>Category *
                    </label>
                    <select id="category" name="category" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a category</option>
                        <option value="Water Supply" {{ old('category') == 'Water Supply' ? 'selected' : '' }}>Water Supply</option>
                        <option value="Electricity" {{ old('category') == 'Electricity' ? 'selected' : '' }}>Electricity</option>
                        <option value="Road Maintenance" {{ old('category') == 'Road Maintenance' ? 'selected' : '' }}>Road Maintenance</option>
                        <option value="Waste Management" {{ old('category') == 'Waste Management' ? 'selected' : '' }}>Waste Management</option>
                        <option value="Public Transport" {{ old('category') == 'Public Transport' ? 'selected' : '' }}>Public Transport</option>
                        <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Public Safety" {{ old('category') == 'Public Safety' ? 'selected' : '' }}>Public Safety</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-exclamation-circle text-gray-400 mr-2"></i>Priority Level *
                    </label>
                    <select id="priority" name="priority" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select priority level</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                            Low - Minor issue, not urgent
                        </option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                            Medium - Moderate issue, needs attention
                        </option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                            High - Important issue, requires prompt action
                        </option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                            Urgent - Critical issue, immediate action required
                        </option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left text-gray-400 mr-2"></i>Detailed Description *
                    </label>
                    <textarea id="description" name="description" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Please provide a detailed description of your complaint, including location, time, and any other relevant information...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        The more details you provide, the better we can assist you.
                    </p>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-md">
                <h3 class="text-sm font-medium text-blue-800 mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>Guidelines for Effective Complaints
                </h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Be specific about the location and time of the incident</li>
                    <li>• Include any reference numbers or previous complaint IDs</li>
                    <li>• Attach photos or documents if available (coming soon)</li>
                    <li>• Use respectful and professional language</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                <a href="/dashboard" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Complaint
                </button>
            </div>
        </form>
    </div>
</div>
@endsection