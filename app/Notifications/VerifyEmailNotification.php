<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verificar Dirección de Correo Electrónico')
            ->greeting('¡Hola!')
            ->line('Por favor, haz clic en el botón a continuación para verificar tu dirección de correo electrónico.')
            ->action('Verificar Dirección de Correo',  $verificationUrl)
            ->line('Si no creaste esta cuenta, puedes ignorar este correo.')
            ->salutation('Saludos');
    }
}
