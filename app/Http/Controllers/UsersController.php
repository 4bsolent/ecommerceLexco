<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UsersService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    use JsonResponse;

    private $userService;

    public function __construct(UsersService $userService) {
        $this->userService = $userService;
    }

    public function createUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'user' => 'required|string|unique:users,user|max:255',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:150',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $this->userService->newUser($request->all());

        return $this->successResponse(['user' => $request->user], 201);
    }
}
