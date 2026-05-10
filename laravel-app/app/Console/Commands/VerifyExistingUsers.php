<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:verify-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark existing users as verified';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verifying existing users...');
        
        $users = User::where('is_verified', '!=', true)->get();
        
        foreach ($users as $user) {
            $user->update([
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->info("Verified user: {$user->email} ({$user->role})");
        }
        
        $this->info("Successfully verified {$users->count()} users.");
        
        return 0;
    }
}