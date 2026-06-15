<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\SellController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ItemController::class, 'index'])
    ->name('items.index');

Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('items.show');

Route::middleware(['auth', 'verified'])->group(function () {

    // コメント・いいね
    Route::post('/comment/{item}', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::post('/like/{item}', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/like/{item}', [LikeController::class, 'destroy'])
        ->name('likes.destroy');

    // プロフィール
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // マイページ
    Route::get('/mypage', [MyPageController::class, 'index'])
        ->name('mypage');

    // 出品
    Route::get('/sell', [SellController::class, 'create'])
        ->name('sell.create');

    Route::post('/sell', [SellController::class, 'store'])
        ->name('sell.store');

    // 購入
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('purchase.address.edit');

    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.address.update');

    Route::post('/purchase/{item}', [PurchaseController::class, 'purchase'])
        ->name('purchase.store');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
