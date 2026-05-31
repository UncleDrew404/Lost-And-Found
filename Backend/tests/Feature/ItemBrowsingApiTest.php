<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemBrowsingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_can_list_categories(): void
    {
        $category = Category::factory()->create([
            'name' => 'Electronics',
            'type' => 'electronics',
        ]);

        $this->getJson('/api/v1/categories')
            ->assertOk()
            ->assertJsonPath('data.0.id', $category->id)
            ->assertJsonPath('data.0.name', 'Electronics')
            ->assertJsonPath('data.0.type', 'electronics');
    }

    public function test_unauthenticated_users_can_list_and_view_items(): void
    {
        $item = $this->createItem([
            'title' => 'Lost umbrella',
        ]);

        $this->getJson('/api/v1/items')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $item->id)
            ->assertJsonPath('data.data.0.title', 'Lost umbrella');

        $this->getJson("/api/v1/items/{$item->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $item->id)
            ->assertJsonPath('data.title', 'Lost umbrella');
    }

    public function test_items_can_be_filtered_by_status(): void
    {
        $activeItem = $this->createItem(['status' => 'active']);
        $this->createItem(['status' => 'resolved']);

        $this->getJson('/api/v1/items?status=active')
            ->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.id', $activeItem->id)
            ->assertJsonPath('data.data.0.status', 'active');
    }

    public function test_items_can_be_filtered_by_type(): void
    {
        $lostItem = $this->createItem(['type' => 'lost']);
        $this->createItem(['type' => 'found']);

        $this->getJson('/api/v1/items?type=lost')
            ->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.id', $lostItem->id)
            ->assertJsonPath('data.data.0.type', 'lost');
    }

    public function test_items_can_be_filtered_by_category(): void
    {
        $electronics = Category::factory()->create(['type' => 'electronics']);
        $documents = Category::factory()->create(['type' => 'documents']);
        $electronicsItem = $this->createItem(['category_id' => $electronics->id]);
        $this->createItem(['category_id' => $documents->id]);

        $this->getJson("/api/v1/items?category={$electronics->id}")
            ->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.id', $electronicsItem->id)
            ->assertJsonPath('data.data.0.category.id', $electronics->id);
    }

    public function test_items_can_be_filtered_by_search(): void
    {
        $matchingItem = $this->createItem([
            'title' => 'Blue wallet',
            'description' => 'Found on campus',
            'location' => 'Library',
        ]);
        $this->createItem([
            'title' => 'Black umbrella',
            'description' => 'Left near the cafeteria',
            'location' => 'Gym',
        ]);

        $this->getJson('/api/v1/items?search=wallet')
            ->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.id', $matchingItem->id)
            ->assertJsonPath('data.data.0.title', 'Blue wallet');
    }

    public function test_items_are_paginated_with_metadata(): void
    {
        Item::factory()
            ->count(3)
            ->create([
                'user_id' => User::factory(),
                'category_id' => Category::factory(),
            ]);

        $this->getJson('/api/v1/items?per_page=2')
            ->assertOk()
            ->assertJsonCount(2, 'data.data')
            ->assertJsonPath('data.meta.per_page', 2)
            ->assertJsonPath('data.meta.total', 3)
            ->assertJsonStructure([
                'data' => [
                    'data',
                    'links',
                    'meta',
                ],
            ]);
    }

    private function createItem(array $attributes = []): Item
    {
        return Item::factory()->create([
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            ...$attributes,
        ]);
    }
}
