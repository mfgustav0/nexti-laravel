<?php

namespace Mfgustav0\Nexti;

use Mfgustav0\Nexti\Commands\NextiCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NextiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('nexti-laravel')
            ->hasConfigFile()
            ->hasCommand(NextiCommand::class);
    }
}
