<?php

namespace Tests\Feature\MailEventsTest;

use Mail;
use Swift_Message;

trait MailTracking
{
    protected array $emails = [];

    public function setUpMailTracking(): void
    {
        Mail::mailer()
            ->getSwiftMailer()
            ->registerPlugin(
                new TestingMailEventsListener($this)
            );

        $this->emails = [];
    }

    public function addEmail(Swift_Message $message): void
    {
        $this->emails[] = $message;
    }

    protected function checkAnyMailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails,
            'No emails have been sent'
        );

        return $this;
    }

    protected function checkAnyMailWasNotSent()
    {
        $this->assertEmpty(
            $this->emails,
            'No emails expected but some were sent'
        );

        return $this;
    }

    protected function checkMailsSent(int $count)
    {
        $actualAmount = count($this->emails);

        $this->assertCount(
            $count,
            $this->emails,
            "Expected {$count} mail(s) to be sent, but got {$actualAmount}"
        );

        return $this;
    }

    protected function hasEmailTo(string $email, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $email,
            $this->getEmail($message)->getTo(),
            "No email was sent to {$email}"
        );

        return $this;
    }

    protected function hasEmailFrom(string $email, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $email,
            $this->getEmail($message)->getFrom(),
            "No email was sent from {$email}"
        );

        return $this;
    }

    protected function checkBodyEquals(string $body, Swift_Message $message = null)
    {
        $this->assertEquals(
            $body,
            $this->getEmail($message)->getBody(),
            "Message body does not match"
        );
    }

    protected function checkBodyContains(string $bodyPart, Swift_Message $message = null)
    {
        $this->assertStringContainsString(
            $bodyPart,
            $this->getEmail($message)->getBody(),
            "Message body does not contain expected string: {$bodyPart}"
        );
    }

    private function getEmail(Swift_Message $message = null)
    {
        $this->checkAnyMailWasSent();

        return $message ?: $this->lastEmail();
    }

    private function lastEmail()
    {
        return end($this->emails);
    }
}
