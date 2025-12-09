<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\CommonNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $user_id, 
        private string $title,
        private string $message,
        private string $link)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $user = User::where('id',$this->user_id)->first();
        if(!$user) {
            return;
        }
        $user->notify(new CommonNotification($this->title,$this->message,$this->link));
    }
}
