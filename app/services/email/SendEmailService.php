<?php

namespace App\services\email;

use App\broker\producer\QueueEmailProducer;

class SendEmailService
{
    private QueueEmailProducer $queueEmailProducer;

    public function __construct()
    {
        $this->queueEmailProducer = new QueueEmailProducer();
    }

    public function sendEmailToQueue(string $recipient, string $subject, string $message): void
    {
        $this->queueEmailProducer->enqueueEmail($recipient, $subject, $message);
    }
}
