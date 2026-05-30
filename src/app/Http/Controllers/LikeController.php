<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // いいね登録
    public function store(Item $item)
    {
        Like::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);

        return redirect()->back();
    }

    // いいね解除
    public function destroy(Item $item)
    {
        Like::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->delete();

        return redirect()->back();
    }
}