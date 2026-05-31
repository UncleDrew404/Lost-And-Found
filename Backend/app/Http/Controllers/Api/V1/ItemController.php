<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use App\Http\Requests\ItemFilterRequest;
use App\Services\ItemService;
use Illuminate\Http\JsonResponse;

class ItemController extends BaseController
{
    protected ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
    public function index(ItemFilterRequest $request): JsonResponse
    {
        $items = $this->itemService->getItems(
            $request->validated()
        );

        $payload = ItemResource::collection($items)
            ->response()
            ->getData(true);

        return $this->success($payload, 'Items retrieved successfully');
    }

    public function show(Item $item): JsonResponse
    {
        $item->load(['user.userProfile', 'category', 'images']);

        return $this->success(new ItemResource($item), 'Item retrieved successfully');
    }
}
