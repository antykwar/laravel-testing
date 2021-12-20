<?php

namespace Tests\Feature\MailEventsTest;

use Swift_Message;

interface MailTrackingTestCase {
    public function addEmail(Swift_Message $message): void;
}
