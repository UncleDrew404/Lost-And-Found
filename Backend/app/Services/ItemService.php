<?php

namespace App\Services;

use App\Models\Item;

class ItemService
{
    public function getItems(array $filters)
    {
        return Item::with(['user.userProfile', 'category', 'images'])
            ->when(
                $filters['status'] ?? null,
                fn($query, $status) =>
                $query->where('status', $status)
            )
            ->when(
                $filters['type'] ?? null,
                fn($query, $type) =>
                $query->where('type', $type)
            )
            ->when(
                $filters['category'] ?? null,
                fn($query, $category) =>
                $query->where('category_id', $category)
            )
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($filters['per_page'] ?? 20)
            ->withQueryString();
    }
}
