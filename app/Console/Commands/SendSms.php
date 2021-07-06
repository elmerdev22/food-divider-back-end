<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendSms:Message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Sms daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app()->call('App\Http\Controllers\Api\Cron\SendSmsController@index');
    }
}
