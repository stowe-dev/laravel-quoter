<?php

namespace Tests\Unit;

use App\Quoter\QuoterManager;
use App\Services\KanyeQuoteService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class QuoterManagerTest extends TestCase
{
    use WithFaker;

    /*
    * Test the default driver is returned
    */
    public function testGetDefaultDriver()
    {
        $manager = new QuoterManager($this->app);

        $defaultEnvDriver = config('quoter.default');

        $this->assertEquals($defaultEnvDriver, $manager->getDefaultDriver());
    }

    /*
    * Test the kanye driver is created
    */
    public function testGetQuote()
    {
        $kanyeQuoteService = $this->createMock(KanyeQuoteService::class);
        $kanyeQuoteService->expects($this->once())
            ->method('getQuote')
            ->willReturn('You have to be odd to be number one.');

        $manager = new QuoterManager($this->app);
        $manager->extend('kanye', fn () => $kanyeQuoteService);

        $quote = $manager->getQuote();

        $this->assertEquals('You have to be odd to be number one.', $quote);
    }

    /*
    * Test the kanye driver is created and returns quotes
    */
    public function testGetQuotes()
    {
        $kanyeQuoteService = $this->createMock(KanyeQuoteService::class);
        $kanyeQuoteService->expects($this->once())
            ->method('getQuotes')
            ->willReturn(new Collection(['Quote 1', 'Quote 2']));

        $manager = new QuoterManager($this->app);
        $manager->extend('kanye', fn () => $kanyeQuoteService);

        $quotes = $manager->getQuotes();

        $this->assertInstanceOf(Collection::class, $quotes);
        $this->assertCount(2, $quotes);
    }
}
