<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Models\LotteryExist;

class LotteryController extends Controller
{
    // 抽奬系統
    public function drawLottery()
    {
        // 獲取所有還沒有抽過獎的用戶
        $users = User::whereNotIn('id', function ($query) {
            $query->select('user_id')->from('lottery_exists');
        })->get();

        // 從中抽取一個幸運的用戶
        $winner = $users->random();

        // 從獎項中選擇一個
        $lottery = Lottery::whereNotIn('id', function ($query) {
            $query->select('lottery_id')->from('lottery_results');
        })->first();

        // 記錄抽獎結果
        LotteryResult::create([
            'user_id' => $winner->id,
            'lottery_id' => $lottery->id,
        ]);

        // 標記這個用戶已經抽過獎
        LotteryExist::create([
            'user_id' => $winner->id,
        ]);

        // 返回結果
        return response()->json([
            'message' => '抽獎完成',
            'winner' => $winner,
            'lottery' => $lottery
        ]);
    }
}
