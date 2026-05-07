<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Citizen Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $complaints = [];
        
        if ($user->role == 'citizen') {
            $complaints = App\Models\Complaint::where('user_id', $user->id)->get();
        } elseif ($user->role == 'admin') {
            $complaints = App\Models\Complaint::all();
        } elseif ($user->role == 'department') {
            // Get complaints assigned to user's department
            $complaints = App\Models\Complaint::where('department_id', $user->department_id)->get();
        }
        
        return view('dashboard', compact('complaints', 'user'));
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture');
    Route::delete('/profile/picture', [ProfileController::class, 'deletePicture'])->name('profile.picture.delete');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Complaint Routes
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/my-complaints', [ComplaintController::class, 'myComplaints'])->name('complaints.my');
    Route::get('/complaints/{complaint}/track', [ComplaintController::class, 'track'])->name('complaints.track');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/complaints', [AdminController::class, 'viewComplaints'])->name('admin.complaints');
    Route::post('/complaints/{complaint}/assign', [AdminController::class, 'assignDepartment'])->name('admin.assign');
    Route::post('/complaints/{complaint}/status', [AdminController::class, 'updateStatus'])->name('admin.status');
    Route::get('/departments', [AdminController::class, 'manageDepartments'])->name('admin.departments');
    Route::post('/departments', [AdminController::class, 'createDepartment'])->name('admin.departments.store');
});

// Department Routes
Route::middleware(['auth', 'department'])->prefix('department')->group(function () {
    Route::get('/dashboard', [DepartmentController::class, 'dashboard'])->name('department.dashboard');
    Route::get('/complaints', [DepartmentController::class, 'viewComplaints'])->name('department.complaints');
    Route::get('/complaints/{complaint}', [DepartmentController::class, 'show'])->name('department.show');
    Route::post('/complaints/{complaint}/status', [DepartmentController::class, 'updateStatus'])->name('department.status');
});
