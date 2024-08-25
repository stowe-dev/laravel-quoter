<?php

namespace App\Quoter;

use App\Services\KanyeQuoteService;
use Illuminate\Support\Collection;
use Illuminate\Support\Manager;

class QuoterManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return config('quote.default', 'kanye');
    }

    public function createKanyeDriver(): QuoterInterface
    {
        return new KanyeQuoteService;
    }

    public function getQuotes($count = 5): Collection
    {
        return $this->driver()->getQuotes($count);
    }

    public function getQuote(): string
    {
        return $this->driver()->getQuote();
    }

    public function clearCache(): void
    {
        $this->driver()->clearCache();
    }
}
