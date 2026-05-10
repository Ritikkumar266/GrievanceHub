@extends('layouts.app')

@section('title', 'Manage Departments - Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manage Departments</h1>
            <p class="text-gray-600 mt-2">Create and manage service departments</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Please fix the following errors:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Create Department Form -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-plus text-green-600 mr-2"></i>Create New Department
            </h2>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.departments.store') }}" class="grid md:grid-cols-3 gap-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department Name</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Water Supply Department">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., water@govt.local">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Brief description">
                </div>
                
                <div class="md:col-span-3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2"></i>Create Department
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Departments List -->
    <div class="bg-white rounded-lg shadow">
        @if($departments && $departments->count() > 0)
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    All Departments ({{ $departments->total() }} total)
                </h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($departments as $department)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $department->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $department->complaints_count }} Complaints
                                    </span>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div class="space-y-1">
                                        <div><i class="fas fa-envelope mr-2"></i>{{ $department->email }}</div>
                                        @if($department->description)
                                            <div><i class="fas fa-info-circle mr-2"></i>{{ $department->description }}</div>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div><i class="fas fa-calendar mr-2"></i>Created: {{ $department->created_at ? $department->created_at->format('M j, Y') : 'Unknown' }}</div>
                                        @php
                                            $deptUser = App\Models\User::where('department_id', $department->id)->where('role', 'department')->first();
                                        @endphp
                                        @if($deptUser)
                                            <div><i class="fas fa-user mr-2"></i>Manager: {{ $deptUser->name }}</div>
                                        @else
                                            <div><i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>No manager assigned</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('admin.complaints') }}?department={{ $department->id }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition text-center">
                                    <i class="fas fa-list mr-1"></i>View Complaints
                                </a>
                                
                                @if(!$deptUser)
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-2">
                                        <div class="text-yellow-800 font-medium mb-2">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>No Manager Assigned
                                        </div>
                                        <button onclick="openManagerModal('{{ $department->id }}', '{{ $department->name }}')" 
                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                            <i class="fas fa-user-plus mr-1"></i>Assign Manager
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Department Stats -->
                        @php
                            $stats = [
                                'pending' => App\Models\Complaint::where('department_id', $department->id)->where('status', 'pending')->count(),
                                'in_progress' => App\Models\Complaint::where('department_id', $department->id)->where('status', 'in-progress')->count(),
                                'resolved' => App\Models\Complaint::where('department_id', $department->id)->where('status', 'resolved')->count(),
                            ];
                        @endphp
                        
                        @if($department->complaints_count > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-4 gap-4 text-center">
                                    <div>
                                        <div class="text-lg font-semibold text-blue-600">{{ $department->complaints_count }}</div>
                                        <div class="text-xs text-gray-500">Total</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-yellow-600">{{ $stats['pending'] }}</div>
                                        <div class="text-xs text-gray-500">Pending</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-blue-600">{{ $stats['in_progress'] }}</div>
                                        <div class="text-xs text-gray-500">In Progress</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-green-600">{{ $stats['resolved'] }}</div>
                                        <div class="text-xs text-gray-500">Resolved</div>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Resolution Progress</span>
                                        <span>{{ $department->complaints_count > 0 ? round(($stats['resolved'] / $department->complaints_count) * 100, 1) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" 
                                             style="width: {{ $department->complaints_count > 0 ? ($stats['resolved'] / $department->complaints_count) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $departments->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-building text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No departments found</h3>
                <p class="text-gray-600 mb-6">Create your first department using the form above.</p>
            </div>
        @endif
    </div>

    <!-- Quick Setup -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Quick Setup</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>To quickly setup all default departments with managers, run:</p>
                    <code class="bg-blue-100 px-2 py-1 rounded mt-1 inline-block">php artisan setup:departments</code>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Manager Modal -->
<div id="managerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-user-plus text-green-600 mr-2"></i>
                    Assign Department Manager
                </h3>
                <button onclick="closeManagerModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="managerForm" method="POST" action="{{ route('admin.create-manager') }}">
                @csrf
                <input type="hidden" id="departmentId" name="department_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <input type="text" id="departmentName" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manager Name *</label>
                    <input type="text" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="e.g., John Smith">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input type="email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="e.g., manager@department.gov">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="Min 8 chars, 1 uppercase, 1 number, 1 special">
                    
                    <!-- Password Requirements -->
                    <div class="mt-2 text-xs text-gray-600">
                        <div class="grid grid-cols-2 gap-2">
                            <div id="req-length" class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-1 text-xs"></i>
                                <span>At least 8 characters</span>
                            </div>
                            <div id="req-uppercase" class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-1 text-xs"></i>
                                <span>One uppercase letter</span>
                            </div>
                            <div id="req-number" class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-1 text-xs"></i>
                                <span>One number</span>
                            </div>
                            <div id="req-special" class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-1 text-xs"></i>
                                <span>One special character</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="Confirm password">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeManagerModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        <i class="fas fa-user-plus mr-2"></i>Create Manager
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openManagerModal(departmentId, departmentName) {
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('departmentName').value = departmentName;
    document.getElementById('managerModal').classList.remove('hidden');
}

function closeManagerModal() {
    document.getElementById('managerModal').classList.add('hidden');
    document.getElementById('managerForm').reset();
    // Reset password requirements
    resetPasswordRequirements();
}

// Close modal when clicking outside
document.getElementById('managerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeManagerModal();
    }
});

// Password validation
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
    
    // Password requirements elements
    const reqLength = document.getElementById('req-length');
    const reqUppercase = document.getElementById('req-uppercase');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');
    
    function updateRequirement(element, met) {
        const icon = element.querySelector('i');
        const text = element.querySelector('span');
        
        if (met) {
            icon.className = 'fas fa-check-circle text-green-500 mr-1 text-xs';
            text.className = 'text-green-600 font-medium';
        } else {
            icon.className = 'fas fa-circle text-gray-300 mr-1 text-xs';
            text.className = 'text-gray-600';
        }
    }
    
    function resetPasswordRequirements() {
        updateRequirement(reqLength, false);
        updateRequirement(reqUppercase, false);
        updateRequirement(reqNumber, false);
        updateRequirement(reqSpecial, false);
    }
    
    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            number: /\d/.test(password),
            special: /[@$!%*?&]/.test(password)
        };
        
        updateRequirement(reqLength, requirements.length);
        updateRequirement(reqUppercase, requirements.uppercase);
        updateRequirement(reqNumber, requirements.number);
        updateRequirement(reqSpecial, requirements.special);
        
        return Object.values(requirements).every(req => req);
    }
    
    passwordInput.addEventListener('input', function() {
        validatePassword(this.value);
    });
    
    // Confirm password matching
    confirmPasswordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.style.borderColor = '#ef4444';
        } else if (confirmPassword && password === confirmPassword) {
            this.style.borderColor = '#10b981';
        } else {
            this.style.borderColor = '#d1d5db';
        }
    });
});
</script>
@endsection