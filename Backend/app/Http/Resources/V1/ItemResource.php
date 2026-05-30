<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'location' => $this->location,
            'date_occured' => $this->date_occured?->toISOString(),
            'contact_info' => $this->contact_info,
            'image_path' => $this->image_path,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'user' => new UserResource($this->whenLoaded('user')),
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(fn ($image) => [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'sort_order' => $image->sort_order,
                    'created_at' => $image->created_at?->toISOString(),
                    'updated_at' => $image->updated_at?->toISOString(),
                ]);
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
