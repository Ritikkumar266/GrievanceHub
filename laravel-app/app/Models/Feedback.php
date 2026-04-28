<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'complaint_id',
        'rating',
        'comment',
    ];

    // Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
