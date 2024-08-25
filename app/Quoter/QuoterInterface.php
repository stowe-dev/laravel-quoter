<?php

namespace App\Quoter;

use Illuminate\Support\Collection;

interface QuoterInterface
{
    public function getQuote(): string;

    public function getQuotes(int $count = 5): Collection;

    public function clearCache(): void;
}
