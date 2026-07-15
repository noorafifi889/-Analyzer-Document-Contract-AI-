<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ReportReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // تمت إضافة المتغير هنا
    public function __construct(protected $report) {}

    public function via($notifiable) 
    { 
        return ['database', 'broadcast']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Analysis Ready',
            'message' => "The analysis for \"{$this->report->name}\" is complete, you can download it now.",
            'report_id' => $this->report->id,
            'icon' => 'file-check', // الأيقونة ستتحول تلقائياً في الهيدر المطور إلى أيقونة صحيحة وممتازة
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}