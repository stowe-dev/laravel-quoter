<?php

return [
    'default' => ENV('QUOTE_DEAFULT', 'kanye'),

    'drivers' => [
        'kanye' => App\Services\KanyeQuoteService::class,
    ],
];
