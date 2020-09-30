<?php

//namespace Tests;

use Illuminate\Support\Facades\Mail;
use Swift_Events_EventListener;
use Swift_Message;

trait MailTracking
{
    protected $emails=[];

    /** @before */
    public function setUpMailTracking()
    {
        parent::setUp();
        Mail::getSwiftMailer()->registerPlugin(new TestingEventMailListener($this));
    }

    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty($this->emails,'No Email was sent!');
        return $this;
    }

    protected function seeEmailWasNotSent()
    {
        $this->assertEmpty($this->emails,'Did not expect email to be sent!');
        return $this;
    }

    protected function seeEmailCount($count)
    {
        $emailCount=count($this->emails);
        $this->assertCount($count,$this->emails,"Expect 2 were sent but ".$emailCount." were");
        return $this;
    }

    protected function seeEmailTo($reciepian , Swift_Message $message=null)
    {
        $this->seeEmailWasSent();

        $this->assertArrayHasKey($reciepian,$this->getEmail($message)->getTo(),"No Email sent to ".$reciepian);
        return $this;
    }

    protected function seeEmailFrom($sender, Swift_Message $message=null)
    {
        $this->seeEmailWasSent();

        $this->assertArrayHasKey($sender,$this->getEmail($message)->getFrom(),"No Email sent to ".$sender);
        return $this;
    }

    protected function seeEmailEqual($body,Swift_Message $message=null)
    {
        $this->assertEquals($body,$this->getEmail($message)->getBody(),"No Email match with the provide body");
        return $this;

    }

    protected function seeEmailContain($contain,Swift_Message $message=null)
    {
        $this->assertTrue((\Str::contains($this->getEmail($message)->getBody(),$contain)),"No Email contain with the provide body");
    }

    protected function getEmail(Swift_Message $message=null)
    {
        return $message?:$this->lastEmail();
    }

    protected function lastEmail(){
        return end($this->emails);
    }

    public function addEmail(Swift_Message $email)
    {
        $this->emails[]=$email;
    }

}


class TestingEventMailListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test=$test;
    }

    public function beforeSendPerformed($event)
    {
        $this->test->addEmail($event->getMessage());
    }
}
