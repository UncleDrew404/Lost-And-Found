<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends BaseController
{
    public function index()
    {
        $items = Item::with(['user.userProfile', 'category', 'images'])
            ->latest()
            ->get();

        return $this->success($items, 'Items retrieved successfully');
    }

    public function store(StoreItemRequest $request)
    {
        $item = Item::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        $item->load(['user.userProfile', 'category', 'images']);

        return $this->created($item, 'Item created successfully');
    }

    public function show(Item $item)
    {
        $item->load(['user.userProfile', 'category', 'images']);

        return $this->success($item, 'Item retrieved successfully');
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        if ($item->user_id !== $request->user()->id) {
            return $this->forbidden('You are not allowed to update this item');
        }

        $item->update($request->validated());
        $item->load(['user.userProfile', 'category', 'images']);

        return $this->success($item, 'Item updated successfully');
    }

    public function destroy(Item $item, Request $request)
    {
        if ($item->user_id !== $request->user()->id) {
            return $this->forbidden('You are not allowed
             to delete this item');
        }

        $item->delete();

        return $this->success(null, 'Item deleted successfully');
    }
}
