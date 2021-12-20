<?php

namespace Tests\Feature;

use Mail;
use Tests\Feature\MailEventsTest\MailTracking;
use Tests\Feature\MailEventsTest\MailTrackingTestCase;
use Tests\TestCase;

class MailEventsTest extends TestCase implements MailTrackingTestCase
{
    use MailTracking;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpMailTracking();
    }

    public function test_mail_sent_with_counter(): void
    {
        $this->sendMail();

        $this
            ->checkAnyMailWasSent()
            ->checkMailsSent(1);
    }

    public function test_mail_sent_with_addresses(): void
    {
        $this->sendMail();

        $this
            ->hasEmailTo('another@test.mail')
            ->hasEmailFrom('one@test.mail');
    }

    public function test_no_email_sent(): void
    {
        $this->checkAnyMailWasNotSent();
    }

    public function test_body_equals(): void
    {
        $this->sendMail();

        $this
            ->checkMailsSent(1)
            ->checkBodyEquals('This is my test message');
    }

    public function test_body_contains(): void
    {
        $this->sendMail();

        $this
            ->checkMailsSent(1)
            ->checkBodyContains('This');
    }

    public function test_integration_mail_sending()
    {
        $this->get('/');

        $this->checkAnyMailWasSent();
    }

    protected function sendMail()
    {
        Mail::raw('This is my test message', function($message) {
            $message->from('one@test.mail');
            $message->to('another@test.mail');
        });
    }
}
