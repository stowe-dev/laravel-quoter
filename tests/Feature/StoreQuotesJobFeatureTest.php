<?php

namespace Tests\Feature;

use App\Jobs\StoreQuotes;
use App\Quoter\Quoter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StoreQuotesJobFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Ensure the quotes table exists
        $this->artisan('migrate');
        Queue::fake();
    }

    /*
    * Test if the job is dispatched
    */
    public function testJobIsDispatched()
    {
        // Dispatch the job
        StoreQuotes::dispatch(3);

        // Assert the job was pushed onto the queue
        Queue::assertPushed(StoreQuotes::class, 1);
    }

    /*
    * Test if the job stores rows
    */
    public function testJobStoresRows()
    {
        // Mock the Quoter class
        Quoter::shouldReceive('getQuotes')
            ->once()
            ->with(3)
            ->andReturn(collect(['Quote 1', 'Quote 2', 'Quote 3']));

        $job = (new StoreQuotes(3))->handle();

        $this->assertDatabaseCount('quotes', 3);
        $this->assertDatabaseHas('quotes', ['quote' => 'Quote 1']);
        $this->assertDatabaseHas('quotes', ['quote' => 'Quote 2']);
        $this->assertDatabaseHas('quotes', ['quote' => 'Quote 3']);

    }
}
