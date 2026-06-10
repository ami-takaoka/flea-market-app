<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_user_can_comment_on_item(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post("/comment/{$item->id}", [
                'content' => 'テストコメント',
            ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_guest_cannot_comment_on_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->post("/comment/{$item->id}", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_comment_content_is_required(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post("/comment/{$item->id}", [
                'content' => '',
            ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_comment_must_not_exceed_255_characters(): void
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $content = str_repeat('a', 256);

        $response = $this->actingAs($user)
            ->post("/comment/{$item->id}", [
                'content' => $content,
            ]);

        $response->assertSessionHasErrors('content');
    }
}
