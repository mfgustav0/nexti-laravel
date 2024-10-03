<?php

namespace Mfgustav0\Nexti\Commands;

use Illuminate\Console\Command;

class NextiCommand extends Command
{
    public $signature = 'nexti-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
