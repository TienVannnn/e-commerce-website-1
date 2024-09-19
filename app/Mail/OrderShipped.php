<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $rand;
    protected $cart;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $rand
     */
    public function __construct(User $user, $rand, $cart)
    {
        $this->user = $user;
        $this->rand = $rand;
        $this->cart = $cart;
    }

    public function build()
    {
        return $this->view('customer.mail.success')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'phone' => $this->user->phone,
                        'address' => $this->user->address,
                        'rand' => $this->rand,
                        'cart' => $this -> cart
                    ]);
    }
}
