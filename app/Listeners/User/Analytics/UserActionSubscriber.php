<?php

namespace App\Listeners\User\Analytics;

use App\Events\User\SignedIn;
use App\Events\User\SignedUp;
use App\Events\User\UserActionEvent;
use App\Services\User\UserActionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

// TODO define how to queue (by redis or rabbit)
class UserActionSubscriber implements ShouldQueue
{
    private UserActionService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserActionService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserActionEvent $event)
    {
        try {
            $this->service->save($event->dto);
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
        }
    }

    public function subscribe($events)
    {
        return [
          SignedUp::class, 'handle',
          SignedIn::class, 'handle',
        ];
    }
}
