<?php
namespace App\Http\Controllers\Api;

use App\Traits\ApiResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }
        $user = auth()->user();

       return $this->ok('Authenticated', [
        'token' => $user->createToken('api-token')->plainTextToken,
       ]);
    }


}
