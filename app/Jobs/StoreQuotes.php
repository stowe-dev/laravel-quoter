<?php

namespace App\Jobs;

use App\Models\Quote;
use App\Quoter\Quoter;
use App\Services\QuoteServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreQuotes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quoteService;

    protected $count;

    /**
     * Create a new job instance.
     *
     * @param  QuoteServiceInterface  $quoteService
     */
    public function __construct(int $count = 100)
    {
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $quotes = Quoter::getQuotes($this->count);

        // Store each quote in the database
        foreach ($quotes as $quoteText) {
            Quote::updateOrCreate(['quote' => $quoteText]);
        }
    }
}
