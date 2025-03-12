<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Permissions\V1\Abilities;

class AuthController extends Controller
{
    use ApiResponses;

    /**
     * Login
     *
     * Authenticates the user and returns the user's API token.
     *
     * @unauthenticated
     * @group Authentication
     * @response 200 {
    "data": {
        "token": "{YOUR_AUTH_KEY}"
    },
    "message": "Authenticated",
    "status": 200
}
     */
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }
        $user = auth()->user();

        return $this->ok('Authenticated', [
         'token' => $user->createToken(
             'api-token',
             Abilities::getAbilities($user),
             now()->addMonth()
         )->plainTextToken,
        ]);
    }

    /**
     * Logout
     *
     * Signs out the user and destroy's the API token.
     *
     * @group Authentication
     * @response 200 {}
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logged out');
    }

}
