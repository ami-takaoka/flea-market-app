<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('sell.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        // 画像保存
        $path = $request
            ->file('image')
            ->store('item_images', 'public');

        // 商品保存
        $item = Item::create([
            'user_id' => Auth::id(),
            'image' => $path,
            'condition' => $request->condition,
            'status' => Item::STATUS_ON_SALE,
            'name' => $request->name,
            'brand' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // カテゴリ紐付け
        $item->categories()->attach($request->categories);

        return redirect()->route('items.index');
    }
}