<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Services\ComplaintService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    protected $complaintService;
    protected $notificationService;

    public function __construct(ComplaintService $complaintService, NotificationService $notificationService)
    {
        $this->complaintService = $complaintService;
        $this->notificationService = $notificationService;
    }

    /**
     * Show department dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $assignedComplaints = Complaint::where('department_id', $user->department_id)->count();
        $resolvedComplaints = Complaint::where('department_id', $user->department_id)
            ->where('status', 'resolved')
            ->count();
        $pendingComplaints = Complaint::where('department_id', $user->department_id)
            ->where('status', 'pending')
            ->count();

        return view('department.dashboard', compact(
            'assignedComplaints',
            'resolvedComplaints',
            'pendingComplaints'
        ));
    }

    /**
     * View assigned complaints
     */
    public function viewComplaints()
    {
        $user = Auth::user();
        $complaints = $this->complaintService->getDepartmentComplaints($user->department_id);

        return view('department.complaints', compact('complaints'));
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
     * View complaint details
     */
    public function show(Complaint $complaint)
    {
        $complaint = $this->complaintService->getComplaintWithHistory($complaint->id);

        return view('department.complaint-detail', compact('complaint'));
    }

    /**
     * View department feedback
     */
    public function viewFeedback()
    {
        $user = Auth::user();
        $feedback = \App\Models\Feedback::whereHas('complaint', function($query) use ($user) {
            $query->where('department_id', $user->department_id);
        })->with(['complaint.user'])->latest()->paginate(15);

        return view('department.feedback', compact('feedback'));
    }
}
