<?php


use Illuminate\Support\Facades\Schedule;

if(env('ENV') === 'production') {
    Schedule::command('app:overview')->daily();
} else {
    Schedule::command('app:overview')->everyFiveMinutes();
}