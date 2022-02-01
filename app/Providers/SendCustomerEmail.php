<?php

namespace App\Providers;

use App\Mail\SubmissionReceived;
use App\Providers\CustomerSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class SendCustomerEmail
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
     * @param  \App\Providers\CustomerSubmitted  $event
     * @return void
     */
    public function handle(CustomerSubmitted $event)
    {
        // var_dump(App::environment());
        if(App::environment('local')){
            Mail::to($event->customer['email'])->send(new SubmissionReceived($event->customer));

        }
        else{
            Mail::to($event->customer['email'])->queue(new SubmissionReceived($event->customer));
        }
    }
}
