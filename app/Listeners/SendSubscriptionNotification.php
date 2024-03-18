<?php

namespace App\Listeners;

use App\Events\Subscribed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubscriptionNotification implements ShouldQueue
{
    public $queue = 'listeners';

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
    public function handle(object $event): void
    {
        //
    }

    public function shouldQueue(Subscribed $event)
    {
        return true;
    }

    public function failed(Subscribed $event, $exception)
    {

    }
}
