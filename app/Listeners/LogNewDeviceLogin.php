<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use App\Notifications\NewDeviceLoginNotification;

class LogNewDeviceLogin
{
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $ip = Request::ip();
        $agent = Request::userAgent();

        $known = $user->logins()->where('ip', $ip)->exists();

        if (! $known) {
            $user->notify(new NewDeviceLoginNotification($ip, $agent));
        }

        $user->logins()->create(['ip' => $ip, 'user_agent' => $agent]);
    }
}