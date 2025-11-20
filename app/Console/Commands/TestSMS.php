<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

include_once __DIR__ . '/../../Http/Controllers/Common.php';

class TestSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        sendSMS('09214915905', '123456', 'activation');
    }
}
