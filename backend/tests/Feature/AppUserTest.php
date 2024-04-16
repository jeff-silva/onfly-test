<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AppUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppUserTest extends TestCase
{
    static $userTest = null;
    static $requestHeaders = [];

    public function test_create()
    {
        $token = JWTAuth::fromUser(AppUser::find(1));
        self::$requestHeaders = ['Authorization' => "Bearer {$token}"];

        self::$userTest = AppUser::factory()->make()->toArray();
        self::$userTest['password'] = '123456';

        $response = $this->json('POST', '/api/app_user', self::$userTest, self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertStatus(201);

        $responseData = json_decode($response->getContent(), true);
        self::$userTest['id'] = $responseData['data']['id'];
    }

    public function test_login()
    {
        $response = $this->json('POST', '/api/auth/login', [
            'email' => self::$userTest['email'],
            'password' => self::$userTest['password'],
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    public function test_update()
    {
        self::$userTest['name'] = 'Foo';
        $response = $this->json('PUT', '/api/app_user/' . self::$userTest['id'], self::$userTest, self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertJsonPath('data.name', 'Foo');
    }

    public function test_delete()
    {
        $response = $this->json('DELETE', '/api/app_user/' . self::$userTest['id'], [], self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertStatus(200);

        AppUser::withTrashed()->find(self::$userTest['id'])->forceDelete();
    }
}
