<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ClearTempImages;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('images:clear-temp', function () {
    $this->call(ClearTempImages::class);
})->purpose('Clear temporary images older than 24 hours');