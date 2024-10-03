<?php

namespace Mfgustav0\Nexti\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Mfgustav0\Nexti\Client withClientId(string|null $clientId)
 * @method static \Mfgustav0\Nexti\Client withClientSecret(string|null $clientSecret)
 * @method static \Mfgustav0\Nexti\Client withDebug()
 * @method static \Mfgustav0\Nexti\Client withoutDebug()
 * @method static \Mfgustav0\Nexti\Services\City city()
 *
 * @see \Mfgustav0\Nexti\Client
 */
class Nexti extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mfgustav0\Nexti\Client::class;
    }
}
