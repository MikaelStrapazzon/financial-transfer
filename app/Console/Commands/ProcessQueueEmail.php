<?php

namespace App\Console\Commands;

use App\broker\consumer\SendEmailConsumer;
use Illuminate\Console\Command;

class ProcessQueueEmail extends Command
{
    private SendEmailConsumer $sendEmailConsumer;

    protected $signature = 'app:process-queue-email';

    public function __construct()
    {
        parent::__construct();

        $this->sendEmailConsumer = new SendEmailConsumer();
    }

    public function handle(): void
    {
        $this->sendEmailConsumer->processQueueEmail();
    }
}
