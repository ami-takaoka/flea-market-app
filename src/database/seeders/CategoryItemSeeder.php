<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::find(1)->categories()->attach([1, 5]);  // 腕時計
        Item::find(2)->categories()->attach([2]);     // HDD
        Item::find(3)->categories()->attach([10]);    // 玉ねぎ3束
        Item::find(4)->categories()->attach([1, 5]);  // 革靴
        Item::find(5)->categories()->attach([2]);     // ノートPC
        Item::find(6)->categories()->attach([2]);     // マイク
        Item::find(7)->categories()->attach([1, 4]);  // ショルダーバッグ
        Item::find(8)->categories()->attach([10]);    // タンブラー
        Item::find(9)->categories()->attach([10]);    // コーヒーミル
        Item::find(10)->categories()->attach([6, 4]); // メイクセット
    }
}
