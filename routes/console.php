<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

//Schedule::command('backup:run')->everyFiveMinutes();
//Schedule::call(function (){
//    Log::info('schedul run at' .now());
//})->everyMinute();

Schedule::call(function () {
    Log::info('schedule run at ' . now());
})->everyMinute();
