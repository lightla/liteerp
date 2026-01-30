<?php


use Illuminate\Support\Facades\Schedule;

if(env('APP_ENV') === 'production') {
    Schedule::command('app:overview')->daily();
} else {
    Schedule::command('app:overview')->everyFiveMinutes();
}
Schedule::command(
    'queue:work --queue=high,default,low --sleep=3 --tries=3 --timeout=30 --max-jobs=1'
)
->everyFiveSeconds()
->withoutOverlapping();