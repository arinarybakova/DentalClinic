<?php

namespace App\Http\Controllers\Auth\Passwords;
use App\Http\Controllers\Auth\Notifications\CreatePassword as CreatePasswordNotification;

trait CanCreatePassword
{
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordCreateNotification($token)
    {
        $this->notify(new CreatePasswordNotification($token));
    }
}
