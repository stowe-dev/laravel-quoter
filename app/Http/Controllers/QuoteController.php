<?php

namespace App\Http\Controllers;

use App\Quoter\QuoterManager;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    protected $quoter;

    public function __construct(QuoterManager $quoter)
    {
        $this->quoter = $quoter;
    }

    public function index(): JsonResponse
    {
        $quotes = $this->quoter->getQuotes();
        return response()->json($quotes);
    }

    public function refresh(): JsonResponse
    {
        // Clear the cache via the service or manager
        $this->quoter->clearCache();

        // Return fresh quotes
        return $this->index();
    }
}
