<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronjobController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renewal-reminder';

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
        Log::info('Renewal reminder command started.');
        $cronjobControl = new CronjobController();
        $cronjobControl->todayDues();
        $cronjobControl->threeDayReminder();
        $cronjobControl->sevenDayReminder();
    }
}
