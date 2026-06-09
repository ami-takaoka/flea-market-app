<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{

    use RefreshDatabase;

    // ========================================
    // 商品一覧
    // ========================================

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

    // ========================================
    // マイリスト
    // ========================================

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

    public function test_mylist_displays_only_liked_items()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create([
            'name' => 'Liked Item',
        ]);

        $notLikedItem = Item::factory()->create([
            'name' => 'Not Liked Item',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee('Liked Item');
        $response->assertDontSee('Not Liked Item');
    }

    public function test_guest_cannot_see_mylist_items()
    {
        $item = Item::factory()->create([
            'name' => 'Test Item',
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee('Test Item');
    }

    public function test_mylist_can_be_filtered_by_keyword()
    {
        $user = User::factory()->create();

        $watch = Item::factory()->create([
            'name' => '腕時計',
        ]);

        $bag = Item::factory()->create([
            'name' => 'バッグ',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $watch->id,
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $bag->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist&keyword=腕');

        $response->assertSee('腕時計');
        $response->assertDontSee('バッグ');
    }

    public function test_sold_label_is_displayed_for_purchased_item_in_mylist()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'Sold Item',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'payment_method' => 1,
        ]);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee('Sold Item');
        $response->assertSee('SOLD');
    }

    // ========================================
    // 商品検索
    // ========================================

    public function test_items_can_be_searched_by_partial_match()
    {
        Item::factory()->create([
            'name' => '腕時計',
        ]);

        Item::factory()->create([
            'name' => 'バッグ',
        ]);

        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);

        $response->assertSee('腕時計');
        $response->assertDontSee('バッグ');
    }

    public function test_search_keyword_is_preserved_when_switching_to_mylist()
    {
        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);

        $response->assertSee('?tab=mylist&amp;keyword=%E8%85%95', false);
    }


}
