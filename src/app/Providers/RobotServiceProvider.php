<?php

namespace App\Providers;

use App\Services\Robot\Robot;
use App\Services\Robot\Source\Source;
use Illuminate\Support\ServiceProvider;
use App\Services\Robot\Source\JsonSource;

class RobotServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->singleton(Robot::class, function ($app) {
            return new Robot();
        });
    }
}
