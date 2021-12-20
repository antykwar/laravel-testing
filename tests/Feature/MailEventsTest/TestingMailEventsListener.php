<?php

namespace Tests\Feature\MailEventsTest;

use Swift_Events_EventListener;
use Tests\TestCase;

class TestingMailEventsListener implements Swift_Events_EventListener
{
    public function __construct(protected MailTrackingTestCase $test) {}

    public function beforeSendPerformed($event): void
    {
        $this->test->addEmail($event->getMessage());
    }
}
