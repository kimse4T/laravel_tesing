<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use MailTracking;
use Swift_Events_Event;
use Swift_Events_EventListener;
use Swift_Message;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use MailTracking;

    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testExample()
    {
        Mail::raw('Hello World', function ($message) {
            $message->from('john@johndoe.com', 'John Doe');
            $message->sender('john@johndoe.com', 'John Doe');
            $message->to('john@johndoe.com', 'John Doe');
            $message->cc('john@johndoe.com', 'John Doe');
            $message->bcc('john@johndoe.com', 'John Doe');
            $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Subject');
            $message->priority(3);
            $message->attach('pathToFile');
        });


        $this->seeEmailWasSent()
             ->seeEmailFrom('john@johndoe.com')
             ->seeEmailTo('john@johndoe.com')
             //->seeEmailWasNotSent()
             ->seeEmailEqual('Hello World')
             ->seeEmailContain('Hello ');
    }

}

