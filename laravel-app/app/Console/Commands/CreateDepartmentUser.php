<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Department;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDepartmentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-department {name} {email} {department} {--password=Dept123!}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a department user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $departmentName = $this->argument('department');
        $password = $this->option('password');

        // Validate password strength
        if (!$this->validatePassword($password)) {
            $this->error("Password does not meet requirements!");
            $this->info("Password must contain:");
            $this->info("• At least 8 characters");
            $this->info("• One uppercase letter");
            $this->info("• One lowercase letter");
            $this->info("• One number");
            $this->info("• One special character (@$!%*?&)");
            return 1;
        }

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Find department
        $department = Department::where('name', $departmentName)->first();
        if (!$department) {
            $this->error("Department '{$departmentName}' not found!");
            $this->info("Available departments:");
            Department::all()->each(function($dept) {
                $this->info("  - {$dept->name}");
            });
            return 1;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'department',
                'department_id' => $department->_id,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);

            $this->info("✅ Department user created successfully!");
            $this->info("📧 Email: {$user->email}");
            $this->info("🔑 Password: {$password}");
            $this->info("👤 Role: {$user->role}");
            $this->info("🏢 Department: {$department->name}");

            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create department user: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Validate password strength
     */
    private function validatePassword($password)
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }
}