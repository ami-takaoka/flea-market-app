<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{

    use RefreshDatabase;

    public function test_all_items_are_displayed(): void
    {
        Item::factory()->create([
            'name' => '商品A',
        ]);

        Item::factory()->create([
            'name' => '商品B',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function test_sold_label_is_displayed_for_purchased_items(): void
    {
        $item = Item::factory()->create([
            'name' => '商品A',
        ]);

        $user = User::factory()->create();

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'payment_method' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('SOLD');
    }

    public function test_user_items_are_not_displayed(): void
    {
        $user = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        Item::factory()->create([
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertSee('他人の商品');

        $response->assertDontSee('自分の商品');
    }
}
