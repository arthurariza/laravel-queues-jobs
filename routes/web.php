<?php

use App\Jobs\ChainJob;
use App\Jobs\PriorityJob;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    foreach (range(1,10) as $item) {
        SendWelcomeEmailJob::dispatch();
    }

    PriorityJob::dispatch();

    return view('welcome');
});

Route::get('/fail', function () {
    PriorityJob::dispatch();

    return view('welcome');
});

Route::get('/chain', function () {
    // Job chaining allows you to specify a list of queued jobs that should be run in sequence
    Bus::chain([
        new ChainJob(),
        new ChainJob(),
        new ChainJob(),
    ])->onQueue('high')->dispatch();

    // If one job in the sequence fails, the rest of the jobs will not be run.
    Bus::chain([
        new ChainJob(true),
        new ChainJob(),
        new ChainJob(),
    ])->onQueue('high')->dispatch();

   return 'Chained';
});
