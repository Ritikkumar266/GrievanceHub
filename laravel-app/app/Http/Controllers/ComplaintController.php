<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Services\ComplaintService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ComplaintController extends Controller
{
    protected $complaintService;
    protected $notificationService;

    public function __construct(ComplaintService $complaintService, NotificationService $notificationService)
    {
        $this->complaintService = $complaintService;
        $this->notificationService = $notificationService;
    }

    /**
     * Show create complaint form
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store new complaint
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $complaint = $this->complaintService->createComplaint($validated);
        $this->notificationService->notifyComplaintSubmitted($complaint);

        return redirect('/dashboard')->with('success', 'Complaint submitted successfully!');
    }

    /**
     * Show complaint details
     */
    public function show(Complaint $complaint)
    {
        // Check if user can view this complaint
        $user = Auth::user();
        if ($user->id !== $complaint->user_id && $user->role !== 'admin' && 
            ($user->role !== 'department' || $user->id !== $complaint->department_id)) {
            abort(403, 'Unauthorized access to this complaint.');
        }

        $complaint = $this->complaintService->getComplaintWithHistory($complaint->id);

        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show user's complaints
     */
    public function myComplaints()
    {
        $complaints = $this->complaintService->getUserComplaints(Auth::id());

        return view('complaints.my-complaints', compact('complaints'));
    }

    /**
     * Track complaint status
     */
    public function track(Complaint $complaint)
    {
        // Check if user can view this complaint
        $user = Auth::user();
        if ($user->id !== $complaint->user_id && $user->role !== 'admin' && 
            ($user->role !== 'department' || $user->id !== $complaint->department_id)) {
            abort(403, 'Unauthorized access to this complaint.');
        }

        $complaint = $this->complaintService->getComplaintWithHistory($complaint->id);

        return view('complaints.track', compact('complaint'));
    }
}
