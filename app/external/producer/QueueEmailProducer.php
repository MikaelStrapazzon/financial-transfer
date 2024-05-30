<?php

namespace App\external\producer;

use Exception;
use Illuminate\Support\Facades\Redis;

class QueueEmailProducer
{
    private mixed $redisClient;

    private string $queueName = 'email_queue';

    public function __construct()
    {
        $this->redisClient = Redis::connection()->client();
    }

    public function enqueueEmail(string $recipient, string $subject, string $message): void
    {
        $emailData = json_encode([
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
        ]);

        try {
            $this->redisClient->rpush($this->queueName, $emailData);
        } catch (Exception) {
        }
    }
}
