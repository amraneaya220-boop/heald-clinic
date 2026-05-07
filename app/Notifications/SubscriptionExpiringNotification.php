<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpiringNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database']; // تقدر تزيد 'mail' لاحقاً
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Subscription Expiring',
            'message' => 'Your subscription will expire soon. Please renew to avoid interruption.',
            'expires_at' => $notifiable->clinic->paid_until,
        ];
    }

    // (اختياري) إذا حبيت email
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Subscription Expiring Soon')
            ->line('Your subscription will expire soon.')
            ->action('Renew Now', url('/subscription'))
            ->line('Thank you!');
    }
}