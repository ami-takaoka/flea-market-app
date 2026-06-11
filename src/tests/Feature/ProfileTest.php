<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    
    use RefreshDatabase;

    // ========================================
    // 購入商品一覧
    // ========================================

    public function test_purchased_items_are_displayed_in_profile(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '購入商品',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'payment_method' => 1,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage?page=buy');

        $response->assertStatus(200);

        $response->assertSee('購入商品');
    }

    public function test_user_information_is_displayed_on_profile_page(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/mypage/profile', [
                'name' => '変更後ユーザー',
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '変更後ユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);
    }

    public function test_postal_code_must_be_valid_format(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/mypage/profile', [
                'name' => 'テストユーザー',
                'postal_code' => '1234567',
                'address' => '東京都渋谷区',
            ]);

        $response->assertSessionHasErrors('postal_code');
    }

    public function test_address_is_required_when_updating_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/mypage/profile', [
                'name' => 'テストユーザー',
                'postal_code' => '123-4567',
                'address' => '',
            ]);

        $response->assertSessionHasErrors('address');
    }

    public function test_name_is_required_when_updating_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/mypage/profile', [
                'name' => '',
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
            ]);

        $response->assertSessionHasErrors('name');
    }
}
