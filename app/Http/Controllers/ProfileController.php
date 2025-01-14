<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\User\UserService;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService  $userService)
    {
        $this->userService  = $userService;
    }

    /**
     * Get user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update user profile
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $data = $request->only('name', 'email');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/images/' . $user->avatar);
            }
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images'), $avatarName);
            $data['avatar'] = $avatarName;
        }
        $this->userService->updateProfile($data, $user->id);

        return redirect()->route('profile.index');
    }
}
