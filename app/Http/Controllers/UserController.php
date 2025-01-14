<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService  $userService)
    {
        $this->userService  = $userService;
    }

    // Lấy tất cả người dùng
    public function index()
    {
        $perPage = config('app.per_page');
        $users = $this->userService->paginate($perPage);
        return view('user.index', compact('users'));
    }

    // Hiển thị form tạo người dùng mới
    public function create()
    {
        return view('user.create');
    }

    // Tạo người dùng mới
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userService->create($data);

            return response()->json(['success' => true, 'message' => 'User created successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    // Hiển thị chi tiết người dùng
    public function show($id)
    {
        $user = $this->userService->find($id);
        return response()->json(['user' => $user]);
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = $this->userService->find($id);
        return view('user.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(UserRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $result = $this->userService->update($data, $id);

            return response()->json(['success' => true, 'message' => 'User updated successfully.', 'emails' => $result]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Xóa người dùng
    public function destroy($id)
    {
        try {
            $this->userService->delete($id);

            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
