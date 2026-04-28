<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    /**
     * Create a new complaint
     */
    public function createComplaint(array $data): Complaint
    {
        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'priority' => $data['priority'] ?? 'medium',
            'status' => 'pending',
        ]);

        // Log the initial status
        $this->logStatusChange($complaint->id, 'pending', 'Complaint submitted');

        return $complaint;
    }

    /**
     * Update complaint status
     */
    public function updateStatus(int $complaintId, string $status, string $remarks = null): void
    {
        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update(['status' => $status]);

        $this->logStatusChange($complaintId, $status, $remarks);
    }

    /**
     * Assign complaint to department
     */
    public function assignToDepartment(int $complaintId, int $departmentId): void
    {
        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update(['department_id' => $departmentId]);

        $this->logStatusChange($complaintId, 'in-progress', 'Assigned to department');
    }

    /**
     * Log status change
     */
    public function logStatusChange(int $complaintId, string $status, string $remarks = null): void
    {
        ComplaintStatusLog::create([
            'complaint_id' => $complaintId,
            'updated_by' => Auth::id(),
            'status' => $status,
            'remarks' => $remarks,
        ]);
    }

    /**
     * Get complaint with all related data
     */
    public function getComplaintWithHistory(int $complaintId): Complaint
    {
        return Complaint::with([
            'user',
            'department',
            'statusLogs.updatedBy',
            'feedback'
        ])->findOrFail($complaintId);
    }

    /**
     * Get all complaints for a user
     */
    public function getUserComplaints(int $userId)
    {
        return Complaint::where('user_id', $userId)
            ->with('department', 'statusLogs')
            ->latest()
            ->get();
    }

    /**
     * Get all complaints for a department
     */
    public function getDepartmentComplaints(int $departmentId)
    {
        return Complaint::where('department_id', $departmentId)
            ->with('user', 'statusLogs')
            ->latest()
            ->get();
    }
}
