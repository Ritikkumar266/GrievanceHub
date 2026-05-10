<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {name} {email} {--password=Admin123!}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
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

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);

            $this->info("✅ Admin user created successfully!");
            $this->info("📧 Email: {$user->email}");
            $this->info("🔑 Password: {$password}");
            $this->info("👤 Role: {$user->role}");

            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create admin user: " . $e->getMessage());
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