<?php

namespace Tests\Unit;

use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a quote can be created successfully.
     */
    public function testCreateQuote()
    {
        $quoteData = ['quote' => 'This is a test quote.'];

        $quote = Quote::create($quoteData);

        $this->assertInstanceOf(Quote::class, $quote);
        $this->assertEquals($quoteData['quote'], $quote->quote);
        $this->assertDatabaseHas('quotes', $quoteData);
    }

    /**
     * Test if a quote can be retrieved successfully.
     */
    public function testRetrieveQuote()
    {
        $quote = Quote::create(['quote' => 'This is a test quote.']);

        $retrievedQuote = Quote::find($quote->id);

        $this->assertNotNull($retrievedQuote);
        $this->assertInstanceOf(Quote::class, $retrievedQuote);
        $this->assertEquals($quote->quote, $retrievedQuote->quote);
    }

    /**
     * Test if a quote can be updated successfully.
     */
    public function testUpdateQuote()
    {
        $quote = Quote::create(['quote' => 'Old quote']);

        $quote->quote = 'Updated quote';
        $quote->save();

        $this->assertDatabaseHas('quotes', ['quote' => 'Updated quote']);
        $this->assertDatabaseMissing('quotes', ['quote' => 'Old quote']);
    }

    /**
     * Test if a quote can be deleted successfully.
     */
    public function testDeleteQuote()
    {
        $quote = Quote::create(['quote' => 'This is a test quote.']);

        $quote->delete();

        $this->assertDatabaseMissing('quotes', ['quote' => 'This is a test quote.']);
    }
}
