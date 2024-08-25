<?php

namespace App\Services;

use App\Quoter\QuoterInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KanyeQuoteService implements QuoterInterface
{
    const CACHE_KEY = 'kanye_quotes';

    public function getQuote(): string
    {
        return Cache::remember(self::CACHE_KEY.'_single', config('cache.ttl', 120), function () {
            try {
                $response = Http::get('https://api.kanye.rest/');

                return $response->json()['quote'];
            } catch (\Exception $e) {
                Log::error('Error fetching Kanye quote: '.$e->getMessage());

                return 'Unable to fetch quote';
            }
        });
    }

    public function getQuotes(int $count = 5): Collection
    {
        return Cache::remember(self::CACHE_KEY, config('cache.ttl', 120), function () use ($count) {
            try {
                $response = Http::get('https://api.kanye.rest/quotes');
                $quotes = $response->json();

                return collect($quotes)->random($count);
            } catch (\Exception $e) {
                Log::error('Error fetching Kanye quotes: '.$e->getMessage());

                return collect(['Unable to fetch quotes']);
            }
        });
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY.'_single');
    }
}
