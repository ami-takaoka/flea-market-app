<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellItemTest extends TestCase
{
    use RefreshDatabase;

    // ========================================
    // 出品
    // ========================================

    public function test_user_can_sell_item(): void
    {
        Storage::fake('public');
    
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => 'テスト説明',
            'price' => 1000,
        ]);

        // 登録した商品とカテゴリの紐付けを確認
        $item = Item::where('name', 'テスト商品')->first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }

    // ========================================
    // バリデーション
    // ========================================

    public function test_name_is_required_when_selling_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => '',
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_is_required_when_selling_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('categories');
    }

    public function test_price_is_required_when_selling_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => '',
            ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_image_is_required_when_selling_item(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $response = $this->actingAs($user)
            ->post('/sell', [
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('image');
    }

    public function test_description_is_required_when_selling_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => '',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_condition_is_required_when_selling_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => '',
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('condition');
    }

    // ========================================
    // 入力値チェック
    // ========================================

    public function test_price_must_be_zero_or_more(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => 'テスト説明',
                'price' => -1,
            ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_name_must_not_exceed_255_characters(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => str_repeat('a', 256),
                'description' => 'テスト説明',
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_description_must_not_exceed_255_characters(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $image = UploadedFile::fake()->create(
            'test.jpg',
            100,
            'image/jpeg'
        );

        $response = $this->actingAs($user)
            ->post('/sell', [
                'image' => $image,
                'categories' => [$category->id],
                'condition' => Item::CONDITION_GOOD,
                'name' => 'テスト商品',
                'description' => str_repeat('a', 256),
                'price' => 1000,
            ]);

        $response->assertSessionHasErrors('description');
    }
}
