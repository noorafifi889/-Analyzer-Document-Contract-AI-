<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function via($notifiable) 
    { 
        return ['database', 'broadcast']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Welcome!',
            'message' => 'Your account has been created successfully 🎉',
            'icon' => 'user-plus',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}