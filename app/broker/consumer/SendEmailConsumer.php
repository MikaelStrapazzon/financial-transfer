<?php

namespace App\broker\consumer;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Throwable;

class SendEmailConsumer
{
    private mixed $redisClient;

    private string $queueName = 'email_queue';

    private string $requeueName = 'email_queue_error';

    public function __construct()
    {
        $this->redisClient = Redis::connection()->client();
    }

    public function processQueueEmail()
    {
        while (true) {
            $data = $this->redisClient->blPop($this->queueName, 0);

            if (! $this->sendEmail()) {
                $this->requeueEmail($data[1]);
            }
        }
    }

    private function sendEmail(): ?bool
    {
        try {
            $response = Http::post('https://util.devi.tools/api/v1/notify');
        } catch (Throwable) {
            return null;
        }

        return $response->successful();
    }

    private function requeueEmail($emailData): void
    {
        try {
            $this->redisClient->rpush($this->requeueName, json_encode($emailData));
        } catch (Exception) {
        }
    }
}
