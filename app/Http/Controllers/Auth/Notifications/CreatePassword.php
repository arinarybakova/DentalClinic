<?php

namespace App\Http\Controllers\Auth\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CreatePassword extends ResetPassword
{
    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Nauja paskyra odontologijos klinikos sistemoje'))
            ->line('Jums buvo sukurta paskyra Odontologijos klinikos informacinėje sistemoje.')
            ->action('Slaptažodžio sukūrimo nuoroda', $url)
            ->line('Paspaudus šią nuorodą, būsite nukreiptas į slaptažodio sukūrimo langą.')
            ->line(Lang::get('Nuoroda galios :count minučių.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line('Likite sveiki,')
            ->line('Odontologijos klinika');
    }
}
