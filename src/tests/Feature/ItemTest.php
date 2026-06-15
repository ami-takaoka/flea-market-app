<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Like;
use App\Models\Category;
use App\Models\Comment;
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

    public function test_sold_label_is_displayed_for_purchased_item_in_mylist(): void
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
            'payment_method' => Purchase::PAYMENT_CONVENIENCE,
        ]);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee('Sold Item');
        $response->assertSee('SOLD');
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
            'payment_method' => Purchase::PAYMENT_CONVENIENCE,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('SOLD');
    }

    public function test_mylist_displays_only_liked_items(): void
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

    public function test_guest_cannot_see_mylist_items(): void
    {
        $item = Item::factory()->create([
            'name' => 'Test Item',
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee('Test Item');
    }

    public function test_mylist_can_be_filtered_by_keyword(): void
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

    // ========================================
    // 商品検索
    // ========================================

    public function test_items_can_be_searched_by_partial_match(): void
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

    public function test_search_keyword_is_preserved_when_switching_to_mylist(): void
    {
        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);

        $response->assertSee('?tab=mylist&amp;keyword=%E8%85%95', false);
    }

    // ========================================
    // 商品詳細
    // ========================================

    public function test_item_detail_displays_required_information(): void
    {
        $item = Item::factory()->create([
            'name' => '腕時計',
            'brand' => 'Rolex',
            'price' => 10000,
            'description' => 'テスト説明',
            'condition' => Item::CONDITION_GOOD,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('腕時計');
        $response->assertSee('Rolex');
        $response->assertSee('10,000');
        $response->assertSee('テスト説明');
        $response->assertSee('良好');
    }

    public function test_multiple_categories_are_displayed(): void
    {
        $item = Item::factory()->create();

        $category1 = Category::create([
            'name' => 'ファッション',
        ]);

        $category2 = Category::create([
            'name' => 'メンズ',
        ]);

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }

    public function test_comment_user_and_content_are_displayed(): void
    {
        $item = Item::factory()->create();

        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('テストコメント');
    }

    public function test_like_count_is_displayed(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        // いいね数が表示されることを確認
        $response->assertSee('1');
    }

    public function test_liked_icon_is_displayed_for_liked_item(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('いいね済み');
    }
}
