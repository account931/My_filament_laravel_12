<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TestJob implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        \Log::info('TestJob executed at '.now());
        dd('Job was dispatched! User is: '.$this->user->email);  // If you used dd(...) or die(...), the job will never be finishes
        // $this->info('Job was dispatched! User is: '.$this->user->email);  //can use it in console command only
        // return 'Job was dispatched! User is: '.   $this->user->email; //Laravel ignores return values in jobs
    }
}
