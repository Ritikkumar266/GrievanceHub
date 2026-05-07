<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentMappingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupDepartments extends Command
{
    protected $signature = 'setup:departments';
    protected $description = 'Setup departments and create department users';

    public function handle()
    {
        $this->info('Setting up departments and users...');

        // Create default departments
        DepartmentMappingService::createDefaultDepartments();
        $this->info('✓ Default departments created');

        // Create department users
        $departments = Department::all();
        
        foreach ($departments as $department) {
            $email = strtolower(str_replace(' ', '.', $department->name)) . '@dept.local';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $department->name . ' Manager',
                    'password' => Hash::make('password'),
                    'role' => 'department',
                    'department_id' => $department->id,
                ]
            );
            
            $this->info("✓ Created user: {$user->name} ({$user->email})");
        }

        $this->info('');
        $this->info('🎉 Setup complete!');
        $this->info('');
        $this->info('Department Users Created:');
        
        $departmentUsers = User::where('role', 'department')->get();
        foreach ($departmentUsers as $user) {
            $this->line("• {$user->name}: {$user->email} (password: password)");
        }
        
        return 0;
    }
}
