<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Complaint extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'complaints';

    protected $fillable = [
        'user_id',
        'department_id',
        'complaint_id',
        'title',
        'description',
        'category',
        'status',
        'priority',
        'address',
        'images',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'images' => 'array',
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

    /**
     * Generate unique complaint ID
     */
    public static function generateComplaintId()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get the count of complaints this month
        $count = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count() + 1;
        
        // Ensure uniqueness by checking if ID already exists
        do {
            $id = sprintf('CMP-%s-%s-%04d', $year, $month, $count);
            $exists = self::where('complaint_id', $id)->exists();
            if ($exists) {
                $count++;
            }
        } while ($exists);
        
        return $id;
    }

    /**
     * Boot method to auto-generate complaint ID
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($complaint) {
            if (empty($complaint->complaint_id)) {
                $complaint->complaint_id = self::generateComplaintId();
            }
        });
    }

    /**
     * Get image URLs
     */
    public function getImageUrlsAttribute()
    {
        if (!$this->images) {
            return [];
        }
        
        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }
}
