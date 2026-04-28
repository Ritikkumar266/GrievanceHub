<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'email',
        'description',
    ];

    // Relationships
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
