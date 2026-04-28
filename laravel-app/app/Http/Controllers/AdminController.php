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
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $departments = Department::count();

        return view('admin.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'resolvedComplaints',
            'departments'
        ));
    }

    /**
     * View all complaints
     */
    public function viewComplaints()
    {
        $complaints = Complaint::with('user', 'department', 'statusLogs')
            ->latest()
            ->paginate(15);

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
        $departments = Department::withCount('complaints')->paginate(10);

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
}
