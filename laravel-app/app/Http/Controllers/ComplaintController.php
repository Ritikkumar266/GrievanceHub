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
            'address' => 'required|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('complaint-images', 'public');
                $imagePaths[] = $path;
            }
        }

        // Add images to validated data
        $validated['images'] = $imagePaths;

        $complaint = $this->complaintService->createComplaint($validated);
        $this->notificationService->notifyComplaintSubmitted($complaint);

        return redirect('/dashboard')->with('success', 'Complaint submitted successfully! Your complaint ID is: ' . $complaint->complaint_id);
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

    /**
     * Submit feedback for resolved complaint
     */
    public function submitFeedback(Request $request, Complaint $complaint)
    {
        // Check if user owns this complaint
        if (Auth::id() !== $complaint->user_id) {
            abort(403, 'Unauthorized access to this complaint.');
        }

        // Check if complaint is resolved
        if ($complaint->status !== 'resolved') {
            return back()->with('error', 'Feedback can only be provided for resolved complaints.');
        }

        // Check if feedback already exists
        if ($complaint->feedback) {
            return back()->with('error', 'Feedback has already been provided for this complaint.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create feedback
        $feedback = new \App\Models\Feedback([
            'complaint_id' => $complaint->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);
        $feedback->save();

        return back()->with('success', 'Thank you for your feedback! It helps us improve our services.');
    }
}
