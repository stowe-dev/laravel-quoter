<?php

namespace App\Console\Commands;

use App\Jobs\StoreQuotes;
use Illuminate\Console\Command;

class StoreQuotesCommand extends Command
{
    protected $signature = 'quotes:store {--count=100 : The number of quotes to store, maximum is 100}';

    protected $description = 'Fetch and store quotes from KanyeQuoteService';

    protected $quoteService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = $this->option('count');

        if ($count > 100) {
            $this->error('The maximum number of quotes that can be stored is 100.');

            return;
        }

        $this->info('Storing '.$count.' quotes...');

        StoreQuotes::dispatch($count);

        $this->info('A Job to store Quotes has been dispatched and will soon be stored.');

    }
}
