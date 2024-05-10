<?php

namespace App\Listeners;

use App\Events\BookAdded;
use App\Mail\BookAddedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookAddedNotification implements ShouldQueue
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
    public function handle(BookAdded $event): void
    {
        $data = [
            'book' => $event->book,
        ];

        Mail::send('emails.book-added', $data, function ($message) use ($data) {
            $message->to('user@gmail.com');
            $message->subject("New Book Added: {$data['book']->title}");
        });
    }
}
