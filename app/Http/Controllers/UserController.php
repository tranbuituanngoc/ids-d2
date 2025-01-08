<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService ;

    public function __construct(UserService  $userService )
    {
        $this->userService  = $userService ;
    }

    // Lấy tất cả người dùng
    public function index()
    {
        $users = $this->userService ->all();
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
        $data = $request->validated();
        $this->userService ->create($data);
        return redirect()->route('user.index');
    }

    // Hiển thị chi tiết người dùng
    public function show($id)
    {
        $user = $this->userService ->find($id);
        return view('user.show', compact('user'));
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = $this->userService ->find($id);
        return view('user.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        $this->userService ->update($data, $id);
        return redirect()->route('user.index');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $this->userService ->delete($id);
        return redirect()->route('user.index');
    }
}
