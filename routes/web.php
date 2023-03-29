<?php

use App\Jobs\PriorityJob;
use App\Jobs\SendWelcomeEmailJob;
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
