<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReactivationStatusChanged extends Notification
{
    use Queueable;

    protected $reactivationRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reactivationRequest)
    {
        $this->reactivationRequest = $reactivationRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->reactivationRequest->status === 'approved') {
            return (new MailMessage)
                ->subject('Account Reactivated')
                ->line('Your account has been reactivated successfully.')
                ->action('Login', route('login'));
        }

        return (new MailMessage)
            ->subject('Reactivation Request Rejected')
            ->line('Your reactivation request has been rejected.')
            ->line('Reason: ' . $this->reactivationRequest->notes);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
