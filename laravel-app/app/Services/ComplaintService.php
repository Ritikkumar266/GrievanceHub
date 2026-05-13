<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use App\Services\DepartmentMappingService;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    /**
     * Create a new complaint
     */
    public function createComplaint(array $data): Complaint
    {
        // Auto-assign department based on category
        $departmentId = DepartmentMappingService::getDepartmentForCategory($data['category']);
        
        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'department_id' => $departmentId, // Auto-assign department
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'priority' => $data['priority'] ?? 'medium',
            'address' => $data['address'] ?? null,
            'images' => $data['images'] ?? [],
            'status' => $departmentId ? 'in-progress' : 'pending', // If department found, set to in-progress
        ]);

        // Log the initial status
        if ($departmentId) {
            $this->logStatusChange($complaint->id, 'in-progress', 'Automatically assigned to ' . $data['category'] . ' department');
        } else {
            $this->logStatusChange($complaint->id, 'pending', 'Complaint submitted, awaiting department assignment');
        }

        return $complaint;
    }

    /**
     * Update complaint status
     */
    public function updateStatus(string $complaintId, string $status, string $remarks = null): void
    {
        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update(['status' => $status]);

        $this->logStatusChange($complaintId, $status, $remarks);
    }

    /**
     * Assign complaint to department
     */
    public function assignToDepartment(string $complaintId, string $departmentId): void
    {
        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update(['department_id' => $departmentId]);

        $this->logStatusChange($complaintId, 'in-progress', 'Assigned to department');
    }

    /**
     * Log status change
     */
    public function logStatusChange(string $complaintId, string $status, string $remarks = null): void
    {
        ComplaintStatusLog::create([
            'complaint_id' => $complaintId,
            'updated_by' => Auth::id(),
            'status' => $status,
            'remarks' => $remarks,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get complaint with all related data
     */
    public function getComplaintWithHistory(string $complaintId): Complaint
    {
        $complaint = Complaint::findOrFail($complaintId);
        
        // Load relationships manually to avoid issues
        try {
            $complaint->load([
                'user', 
                'department', 
                'statusLogs.updatedBy', // Load the user who updated each status
                'feedback'
            ]);
        } catch (\Exception $e) {
            // If relationships fail to load, continue without them
        }
        
        return $complaint;
    }

    /**
     * Get all complaints for a user
     */
    public function getUserComplaints(string $userId)
    {
        return Complaint::where('user_id', $userId)
            ->with(['department', 'statusLogs.updatedBy'])
            ->latest()
            ->get();
    }

    /**
     * Get all complaints for a department
     */
    public function getDepartmentComplaints(string $departmentId)
    {
        return Complaint::where('department_id', $departmentId)
            ->with(['user', 'statusLogs.updatedBy'])
            ->latest()
            ->get();
    }
}
