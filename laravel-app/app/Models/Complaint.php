<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'title',
        'description',
        'category',
        'status',
        'priority',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
