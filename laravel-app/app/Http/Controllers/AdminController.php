<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Department;
use App\Models\User;
use App\Services\ComplaintService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $complaintService;
    protected $notificationService;

    public function __construct(ComplaintService $complaintService, NotificationService $notificationService)
    {
        $this->complaintService = $complaintService;
        $this->notificationService = $notificationService;
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $inProgressComplaints = Complaint::where('status', 'in-progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $departments = Department::count();
        $totalUsers = User::count();
        $citizenUsers = User::where('role', 'citizen')->count();
        $departmentUsers = User::where('role', 'department')->count();

        // Department-wise complaint counts (MongoDB compatible)
        $departmentStats = Department::all();
        foreach ($departmentStats as $dept) {
            $dept->complaints_count = Complaint::where('department_id', $dept->id)->count();
        }

        // Recent complaints
        $recentComplaints = Complaint::with('user', 'department')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'departments',
            'totalUsers',
            'citizenUsers',
            'departmentUsers',
            'departmentStats',
            'recentComplaints'
        ));
    }

    /**
     * View all complaints
     */
    public function viewComplaints(Request $request)
    {
        $query = Complaint::with('user', 'department', 'statusLogs');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $complaints = $query->latest()->paginate(15);

        return view('admin.complaints', compact('complaints'));
    }

    /**
     * Assign complaint to department
     */
    public function assignDepartment(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $this->complaintService->assignToDepartment($complaint->id, $validated['department_id']);
        $this->notificationService->notifyDepartmentNewComplaint($complaint);

        return back()->with('success', 'Complaint assigned successfully!');
    }

    /**
     * Update complaint status
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,resolved,rejected',
            'remarks' => 'nullable|string',
        ]);

        $this->complaintService->updateStatus(
            $complaint->id,
            $validated['status'],
            $validated['remarks']
        );

        $this->notificationService->notifyStatusUpdate($complaint, $validated['status']);

        return back()->with('success', 'Status updated successfully!');
    }

    /**
     * Manage departments
     */
    public function manageDepartments()
    {
        // Get departments with manual complaint count since withCount doesn't work with MongoDB
        $departments = Department::paginate(10);
        
        // Add complaint counts manually
        foreach ($departments as $department) {
            $department->complaints_count = Complaint::where('department_id', $department->id)->count();
        }

        return view('admin.departments', compact('departments'));
    }

    /**
     * Create department
     */
    public function createDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments',
            'email' => 'required|email|unique:departments',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return back()->with('success', 'Department created successfully!');
    }

    /**
     * View all feedback
     */
    public function viewFeedback(Request $request)
    {
        $query = \App\Models\Feedback::with(['complaint.user', 'complaint.department']);

        // Apply filters
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('department')) {
            $query->whereHas('complaint', function($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $feedback = $query->latest()->paginate(15);

        return view('admin.feedback', compact('feedback'));
    }
}
