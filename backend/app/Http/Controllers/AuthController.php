<?php

namespace App\Http\Controllers;

use App\Annotations\Openapi;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected function tokenResponse($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

    #[Openapi\Param(['name' => 'email', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'password', 'in' => 'body', 'type' => 'string'])]
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            throw new ApiError(401, 'Unauthorized');
        }
        return $this->tokenResponse($token);
    }

    public function logout()
    {
        auth()->logout();
        return ['message' => 'Successfully logged out'];
    }

    public function refresh()
    {
        return $this->tokenResponse(auth()->refresh());
    }

    public function user()
    {
        return auth()->user();
    }
}
