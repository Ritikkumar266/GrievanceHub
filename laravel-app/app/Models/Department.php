<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'departments';

    protected $fillable = [
        'name',
        'email',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
