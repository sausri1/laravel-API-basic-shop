<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNull;

class UserAuthController extends Controller
{
    public function signup(StoreUserRequest $request) {
        $user = User::create($request->validated());
        return response()->json([
            "user_token" => $user->createToken("token: {$user->name}")->plainTextToken,
        ]);
    }
    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'user' => [
                "id" => $user->id,
                "fio" => $user->fio,
                "avatar" => $user->avatar,
                "email" => $user->email,
            ]
        ])->header('Content-Type', 'application/json');
    }
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return response()->json([
            "message" => "data updated successfully"
        ], 200);
    }
    public function login(LoginUserRequest $request) {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['password' => 'Login failed'], 401);
        }
        $user = Auth::user();
        return response()->json([
            "user_token" => $user->createToken("token: {$user->name}")->plainTextToken
        ], 200);
    }
    public function logout(Request $request) {
        Auth::user()->currentAccessToken()->delete(); //other tokens will delete after 1 hour
        return response()->json([
            "message" => "logout"
        ]);
    }
}
