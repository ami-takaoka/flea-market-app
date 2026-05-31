<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'image',
        'price',
        'description',
        'condition',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | リレーション
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Condition
    |--------------------------------------------------------------------------
    */

    public const CONDITION_GOOD = 1;
    public const CONDITION_NO_DAMAGE = 2;
    public const CONDITION_SCRATCH = 3;
    public const CONDITION_BAD = 4;

    public const CONDITIONS = [
        self::CONDITION_GOOD => '良好',
        self::CONDITION_NO_DAMAGE => '目立った傷や汚れなし',
        self::CONDITION_SCRATCH => 'やや傷や汚れあり',
        self::CONDITION_BAD => '状態が悪い',
    ];

    public function getConditionLabelAttribute()
    {
        return self::CONDITIONS[$this->condition] ?? '';
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    public const STATUS_ON_SALE = 0;
    public const STATUS_SOLD = 1;

    public const STATUSES = [
        self::STATUS_ON_SALE => '販売中',
        self::STATUS_SOLD => 'SOLD',
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? '';
    }

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}