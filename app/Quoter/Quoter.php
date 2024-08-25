<?php

namespace App\Quoter;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getQuote()
 * @method static \Illuminate\Support\Collection getQuotes(int $count = 5)
 */
class Quoter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'quoter';
    }
}
