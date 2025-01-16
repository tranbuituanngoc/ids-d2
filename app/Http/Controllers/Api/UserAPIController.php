<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use App\Exceptions\UserNotFoundException;

class UserAPIController extends Controller
{
    protected $userService;

    public function __construct(UserService  $userService)
    {
        $this->userService  = $userService;
    }

    public function getAllUsers()
    {
        $users = $this->userService->all();
        return response()->json(['success' => true, 'message' => 'Get all users successfully.', 'data' => $users]);
    }

    public function createUser(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userService->create($data);

            return response()->json(['success' => true, 'message' => 'User created successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }
    public function getUser($id)
    {
        try {
            $user = $this->userService->find($id);
            if (!$user) {
                throw new UserNotFoundException();
            }
            return response()->json($user);
        } catch (UserNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }

    public function updateUser(UserRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->userService->update($data, $id);

            return response()->json(['success' => true, 'message' => 'User updated successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    public function deleteUser($id)
    {
        try {
            $this->userService->delete($id);

            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }
}
