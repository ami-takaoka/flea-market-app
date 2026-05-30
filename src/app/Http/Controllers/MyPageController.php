<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 購入商品
        if ($request->page === 'buy') {

            $items = $user->purchases()
                ->with('item.purchase')
                ->get()
                ->pluck('item');

        // 出品商品
        } else {

            $items = $user->items()
                ->with('purchase')
                ->get();
        }

        return view('mypage.index', compact(
            'user',
            'items'
        ));
    }
}