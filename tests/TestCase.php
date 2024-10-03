<?php

namespace Mfgustav0\Nexti\Tests;

use Mfgustav0\Nexti\NextiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            NextiServiceProvider::class,
        ];
    }
}
