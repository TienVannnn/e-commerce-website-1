<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $rand;
    protected $cart;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $rand
     */
    public function __construct(User $user, $rand, $cart)
    {
        $this->user = $user;
        $this->rand = $rand;
        $this -> cart  = $cart;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new OrderShipped($this->user, $this->rand, $this -> cart));
    }
}
