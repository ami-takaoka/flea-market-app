<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // マイリスト
        if ($request->tab === 'mylist') {
            // 未ログイン時は空
            if (!Auth::check()) {
                $items = collect();
            } else {
                $items = Item::whereHas('likes', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                    ->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->with([
                        'likes',
                        'comments',
                        'purchase',
                    ])
                    ->latest()
                    ->get();
            }
        } else {
            // おすすめ
            $query = Item::query();

            $query->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });

            $query->with([
                'likes',
                'comments',
                'purchase',
            ]);

            // 自分の商品除外
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }

            $items = $query->latest()->get();
        }

        return view('items.index', compact('items'));
    }

    public function show(Item $item)
    {
        $item->load([
            'user',
            'categories',
            'comments.user',
            'likes',
            'purchase',
        ]);

        return view('items.show', compact('item'));
    }
}