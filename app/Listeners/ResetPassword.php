<?php

namespace App\Listeners;

use App\Providers\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;

class ResetPassword
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        // $response = property_exists(Password::class, 'PASSWORD_RESET') ? 
        //     Password::PASSWORD_RESET : 'Your password has been reset!';
        $response = 'Your password has been reset!';
        session()->flash('success', trans($response));
    }
}
