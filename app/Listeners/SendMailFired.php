<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\SendMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendMail $event): void
    {
        $url = URL::to('/user-login');
        $data['url'] = $url;
        $data['name'] = $event->userID['name'];
        $data['email'] = $event->userID['email'];
        $data['password'] = $event->userID['passwordx'];
        $data['title'] = 'New User Registration';

        Mail::send('registrationMail', ['data'=>$data], function ($message) use ($data) {
            $message->to($data['email']);
            $message->subject($data['title']);
        });
    }
}
