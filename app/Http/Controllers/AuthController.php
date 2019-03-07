<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['test', 'register', 'forgetPassword', 'resetPassword', 'resetPasswordByToken']);
    }


    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'phone'     => $request->get('phone', null),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    public function reset(Request $request)
    {
        $this-> resetPassword($request);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|hash:' . auth()->user()->password,
            'password'     => 'required|different:old_password|confirmed',
        ], [
            'old_password.hash' => '旧密码输入错误！',
        ], [
            'old_password' => '旧密码',
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json();
    }

    /**
     * Get the password reset credentials from the request.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }


    public function broker()
    {
        return Password::broker();
    }
}
