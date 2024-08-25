<?php

namespace Tests\Unit;

use App\Services\KanyeQuoteService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class KanyeQuoteServiceTest extends TestCase
{
    /*
    * Test we can fetch a single quote
    */
    public function testCanGetQuote()
    {
        Http::fake([
            'https://api.kanye.rest/' => Http::response(['quote' => 'Test quote']),
        ]);

        $service = new KanyeQuoteService;
        $quote = $service->getQuote();

        $this->assertIsString($quote);
        $this->assertEquals('Test quote', $quote);
    }

    /*
    * Test we can fetch multiple quotes
    */
    public function testCanGetQuotes()
    {
        $quotes = [
            'Test quote 1',
            'Test quote 2',
            'Test quote 3',
            'Test quote 4',
            'Test quote 5',
        ];

        Http::fake([
            'https://api.kanye.rest/quotes' => Http::response($quotes),
        ]);

        $service = new KanyeQuoteService;
        $fetchedQuotes = $service->getQuotes();

        $this->assertInstanceOf(Collection::class, $fetchedQuotes);
        $this->assertTrue($fetchedQuotes->every(fn ($quote) => in_array($quote, $quotes)));
    }

    /*
    * Test the service handles an exception
    */
    public function testGetQuotesHandlesException()
    {
        Http::shouldReceive('get')
            ->once()
            ->with('https://api.kanye.rest/quotes')
            ->andThrow(new Exception('API ERROR'));

        Log::shouldReceive('error')
            ->once()
            ->with('Error fetching Kanye quotes: API ERROR');

        $service = new KanyeQuoteService;
        $quotes = $service->getQuotes();

        $this->assertCount(1, $quotes);
        $this->assertEquals('Unable to fetch quotes', $quotes->first());
    }
}
