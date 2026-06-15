<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'postal_code',
        'address',
        'building',
        'payment_method',
    ];

    // ======================
    // リレーション
    // ======================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    //======================
    // Payment Method
    //======================

    public const PAYMENT_CONVENIENCE = 1;
    public const PAYMENT_CARD = 2;

    public const PAYMENT_METHODS = [
        self::PAYMENT_CONVENIENCE => 'コンビニ払い',
        self::PAYMENT_CARD => 'カード払い',
    ];

    public function getPaymentMethodLabelAttribute()
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? '';
    }
}