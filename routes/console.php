<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

//Schedule::command('backup:run')->everyFiveMinutes();
Schedule::command('backup:runs')->daily()->at('00:00');
Schedule::job(new \App\Jobs\ProcessPendingMessageJob())->everyTwoMinutes();
