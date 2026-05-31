<?php

namespace App\Http\Controllers\Api\V1\Staff;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdateClaimStatusRequest;
use App\Http\Resources\V1\ClaimResource;
use App\Models\Claim;

class ClaimController extends BaseController
{
    public function index()
    {
        $claims = Claim::with(['item.category', 'item.images', 'item.user.userProfile', 'user.userProfile'])
            ->latest()
            ->paginate(10);

        return $this->success(ClaimResource::collection($claims), 'Claims retrieved successfully');
    }

    public function updateStatus(UpdateClaimStatusRequest $request, Claim $claim)
    {
        $claim->update($request->validated());
        $claim->load(['item.category', 'item.images', 'item.user.userProfile', 'user.userProfile']);

        return $this->success(new ClaimResource($claim), 'Claim status updated successfully');
    }
}
