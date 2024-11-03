<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $data  = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [ 'required', 'string', 'email', 'max:255', Rule::unique(User::class),],
                'password' => ['required','min:8'],
            ]);

            $user = User::create(array_merge($data, ['role' => 'user_mobile']));

            $token = $user->createToken('auth_token');

            return (new UserResource($user))->additional([
                'token' => $token->plainTextToken,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function login(Request $request){
        try {
            $data  = $request->validate([
                'email' => [ 'required', 'string', 'email', 'max:255'],
                'password' => ['required','min:8'],
            ]);

            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'Bad credentials'], 422);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'user'    => $user,
                'token'   => $token
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

