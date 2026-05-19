<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::with('userProfile')->get();
        return $this->success($users, 'Users retrieved successfully');
    }
}
