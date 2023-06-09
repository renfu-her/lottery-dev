<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LotteryController;

Route::get('/', function () {
    return view('welcome');
});

route::get('/lottery_result', [LotteryController::class, 'drawLottery']);
