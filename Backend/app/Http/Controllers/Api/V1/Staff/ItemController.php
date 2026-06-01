<?php

namespace App\Http\Controllers\Api\V1\Staff;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;

class ItemController extends BaseController
{
    public function store(StoreItemRequest $request)
    {
        $item = Item::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        $item->load(['user.userProfile', 'category', 'images']);

        return $this->created(new ItemResource($item), 'Item created successfully');
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        $item->load(['user.userProfile', 'category', 'images']);    

        return $this->success(new ItemResource($item), 'Item updated successfully');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return $this->success(null, 'Item deleted successfully');
    }
}
