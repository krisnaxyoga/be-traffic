<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\User_scores;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
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

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true]);
    }

    public function users(){
        try {

            //get posts
            $user = Auth::user();
            $posts = User::where('id', $user->id)
                ->with('user_scores')
                ->addSelect(['total_score' => User_scores::whereColumn('id_user', 'users.id')->selectRaw('sum(score)')])
                ->get();
            //return collection of posts as a resource
            return new DataResource(true, 'List Data User', $posts);
        }  catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

