<?php

namespace App\Listeners;

use App\Events\JobDeleted;
use App\Services\Jobs\GoogleIndexingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class JobDeleteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event)
    {
        $job = $event->job;
        $notified = GoogleIndexingService::deleteJobIndexing($job);
    }
}
