<?php

namespace Mfgustav0\Nexti\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mfgustav0\Nexti\Nexti
 */
class Nexti extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mfgustav0\Nexti\Nexti::class;
    }
}
