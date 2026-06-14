<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isCurrentUser = $request->user()?->id === $this->id;
        $canViewUsers = $request->user()?->can('users.view') ?? false;
        $isAuthResponse = ! $request->user();

        return [
            'id' => $this->id,
            'email' => $this->when($isCurrentUser || $canViewUsers || $isAuthResponse, $this->email),
            'status' => $this->when($isCurrentUser || $canViewUsers, $this->status),
            // 'profile' => $this->whenLoaded('userProfile', function () {
            //     return [
            //         'id' => $this->userProfile?->id,
            //         'first_name' => $this->userProfile?->first_name,
            //         'middle_name' => $this->userProfile?->middle_name,
            //         'last_name' => $this->userProfile?->last_name,
            //         'full_name' => collect([
            //             $this->userProfile?->first_name,
            //             $this->userProfile?->middle_name,
            //             $this->userProfile?->last_name,
            //         ])->filter()->implode(' ') ?: null,
            //         'gender' => $this->userProfile?->gender,
            //         'phone_number' => $this->userProfile?->phone_number,
            //         'bio' => $this->userProfile?->bio,
            //         'avatar' => $this->userProfile?->avatar,
            //         'department' => $this->userProfile?->department,
            //         'student_id' => $this->userProfile?->student_id,
            //     ];
            // }),
            'roles' => $this->when($isCurrentUser || $canViewUsers || $isAuthResponse, fn () => $this->getRoleNames()->values()),
            // 'permissions' => $this->when($isCurrentUser || $isAuthResponse, fn () => $this->getAllPermissions()->pluck('name')->values()),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
