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
    }
}
