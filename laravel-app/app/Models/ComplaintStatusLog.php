<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ComplaintStatusLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'complaint_status_logs';

    public $timestamps = true;

    protected $fillable = [
        'complaint_id',
        'updated_by',
        'status',
        'remarks',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
