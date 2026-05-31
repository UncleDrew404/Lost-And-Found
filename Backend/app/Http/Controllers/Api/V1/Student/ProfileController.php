<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    public function show(Request $request)
    {
        return $this->success(
            new UserResource($request->user()->load(['roles.permissions', 'userProfile'])),
            'Profile retrieved successfully'
        );
    }

    public function update(UpdateUserProfileRequest $request)
    {
        UserProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $request->validated()
        );

        return $this->success(
            new UserResource($request->user()->load(['roles.permissions', 'userProfile'])),
            'Profile updated successfully'
        );
    }
}
