<?php

namespace Tests\Feature;

use App\Quoter\Quoter;
use Tests\TestCase;

class QuoteApiTest extends TestCase
{
    protected $authorisedHeaders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorisedHeaders = ['Authorization' => config('services.api.token')];
    }

    /*
    * Test to check if the API can fetch quotes
    */
    public function testCanFetchQuotes()
    {
        $response = $this->getJson('/api/quotes', $this->authorisedHeaders);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    /*
    * Test to check if the API can fetch quotes
    */
    public function testCanRefreshQuotes()
    {
        $response = $this->getJson('/api/quotes/refresh', $this->authorisedHeaders);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function testRefreshClearsCacheAndReturnsNewQuotes()
    {
        // Make a GET request to the quotes endpoint
        $response = $this->getJson('/api/quotes', $this->authorisedHeaders);

        // // Assert the response is successful and matches the quotes
        $response->assertStatus(200)
            ->assertJsonCount(5);

        // Get the quotes from the response
        $quotes = collect($response->json());

        // Make a GET request to the refresh endpoint
        $response = $this->getJson('/api/quotes/refresh', $this->authorisedHeaders);

        // Assert response is successful and does not match the previous quotes
        $response->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonMissing($quotes->toArray());
    }

    public function testUnauthorizedAccess()
    {
        $response = $this->getJson('/api/quotes');

        $response->assertStatus(401);
    }
}
