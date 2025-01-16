<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;

class AuthAPIController extends Controller
{
    protected $userService;

    public function __construct(UserService  $userService)
    {
        $this->userService  = $userService;
    }
    /**
     * Register a new user API
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $user =  $this->userService->create($data);
            $token = JWTAuth::fromUser($user);

            return response()->json(['success' => true, 'user' => $user, 'token' => $token, 'message' => 'User created successfully.'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(compact('token'));
    }
}
