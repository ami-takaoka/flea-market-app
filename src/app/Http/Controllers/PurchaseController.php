<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // 購入画面
    public function create(Item $item)
    {
        $user = Auth::user();

        return view('purchase.create', compact('item', 'user'));
    }

    // 住所変更画面
    public function editAddress(Item $item)
    {
        $user = Auth::user();

        return view('purchase.address', compact('item', 'user'));
    }

    // 住所変更保存
    public function updateAddress(AddressRequest $request, Item $item)
    {
        session([
            'purchase_address' => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect()->route('purchase.create', $item);
    }

    // 購入処理
    public function purchase(PurchaseRequest $request, Item $item)
    {
        $address = session('purchase_address');

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'postal_code' => $address['postal_code']
                ?? Auth::user()->postal_code,
            'address' => $address['address']
                ?? Auth::user()->address,
            'building' => $address['building']
                ?? Auth::user()->building,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('items.index');
    }
}