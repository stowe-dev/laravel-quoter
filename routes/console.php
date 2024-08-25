<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('quotes:store')->daily();
