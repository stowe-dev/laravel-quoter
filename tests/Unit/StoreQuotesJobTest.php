<?php

namespace Tests\Unit;

use App\Jobs\StoreQuotes;
use App\Quoter\Quoter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreQuotesJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    /*
    * Test if quotes are stored in the database
    */
    public function testQuotesAreStoredInDatabase()
    {
        $quotes = collect(['Quote 1', 'Quote 2', 'Quote 3']);

        Quoter::shouldReceive('getQuotes')
            ->once()
            ->with(3)
            ->andReturn($quotes);

        $job = new StoreQuotes(3);
        $job->handle();

        foreach ($quotes as $quote) {
            $this->assertDatabaseHas('quotes', ['quote' => $quote]);
        }
    }

    /*
    * Test if only unique quotes are stored in the database
    */
    public function testOnlyUniqueQuotesAreStored()
    {
        $quotes = collect(['Quote 1', 'Quote 2', 'Quote 1']);

        Quoter::shouldReceive('getQuotes')
            ->once()
            ->with(3)
            ->andReturn($quotes);

        $job = new StoreQuotes(3);
        $job->handle();

        $this->assertDatabaseCount('quotes', 2);
        $this->assertDatabaseHas('quotes', ['quote' => 'Quote 1']);
        $this->assertDatabaseHas('quotes', ['quote' => 'Quote 2']);
    }

    /*
    * Test if the job respects the count parameter
    */
    public function testJobRespectsCountParameter()
    {
        $quotes = collect(['Quote 1', 'Quote 2']);

        Quoter::shouldReceive('getQuotes')
            ->once()
            ->with(2)
            ->andReturn($quotes);

        $job = new StoreQuotes(2);
        $job->handle();

        $this->assertDatabaseCount('quotes', 2);
    }
}
