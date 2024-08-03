<?php
namespace App\Http\Controllers\Api;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;

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
        'token' => $user->createToken(
            'api-token',
            ['*'],
            now()->addMonth()
            )->plainTextToken,
       ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->ok('Logged out');
    }

}
