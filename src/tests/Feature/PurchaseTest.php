<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    
    use RefreshDatabase;

    // ========================================
    // 配送先変更
    // ========================================

    public function test_changed_address_is_displayed_on_purchase_page(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->withSession([
                'purchase_address' => [
                    'postal_code' => '999-9999',
                    'address' => '大阪府大阪市',
                    'building' => 'テストビル',
                ]
            ])
            ->get("/purchase/{$item->id}");

            $response->assertStatus(200);
            
            $response->assertSee('999-9999');
            $response->assertSee('大阪府大阪市');
            $response->assertSee('テストビル');
    }

    public function test_payment_method_is_required(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post("/purchase/{$item->id}", [
                'payment_method' => '',
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
            ]);

        $response->assertSessionHasErrors('payment_method');
    }

    public function test_address_is_required_when_purchasing(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post("/purchase/{$item->id}", [
                'payment_method' => 1,
                'postal_code' => '',
                'address' => '',
            ]);

        $response->assertSessionHasErrors([
            'postal_code',
            'address',
        ]);
    }

    
}
