<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create($request->validated());

        $data = array_merge(
            $user->only(['id', 'name', 'email']),
            ['token' => $user->createToken('calendlyApp')->plainTextToken]
        );

        return response()->json($data);
    }

    public function login()
    {
        if(auth()->attempt(request()->only(['email', 'password']))){
            $user = auth()->user();

            $data = array_merge(
                $user->only(['id', 'name', 'email']),
                ['token' => $user->createToken('calendlyApp')->plainTextToken]
            );

            return response()->json($data);
        }else{
            return response()->json(['message' => 'Sorry please check your credential'], 401);
        }
    }

    public function updateProfile(UserRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
