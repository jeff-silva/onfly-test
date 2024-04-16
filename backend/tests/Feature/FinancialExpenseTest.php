<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AppUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinancialExpenseTest extends TestCase
{
    public function test_create(): void
    {
        // $user = AppUser::find(1);
        // $token = JWTAuth::fromUser($user);
        // dump($token);
    }
}
