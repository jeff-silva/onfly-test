<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AppUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppUserTest extends TestCase
{
    static $requestHeaders = [];
    static $userAuth = [
        'name' => 'auth@grr.la',
        'email' => 'auth@grr.la',
        'password' => 'auth@grr.la',
    ];
    static $userTest = null;

    public function test_login()
    {
        $userAuth = AppUser::create(self::$userAuth);
        self::$userAuth['id'] = $userAuth->id;

        $loginResp = $this->json('POST', '/api/auth/login', [
            'email' => self::$userAuth['email'],
            'password' => self::$userAuth['password'],
        ]);

        $loginResp
            ->assertStatus(200)
            ->assertJsonStructure(['access_token']);

        $loginRespData = json_decode($loginResp->getContent());

        $this->assertTrue(!!$loginRespData->access_token);
        self::$requestHeaders = ['Authorization' => "Bearer {$loginRespData->access_token}"];
    }

    public function test_create()
    {
        $userData = AppUser::factory()->make()->toArray();
        $userData['password'] = '123456';

        $response = $this->json('POST', '/api/app_user', $userData, self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertStatus(201);

        $responseData = json_decode($response->getContent(), true);
        self::$userTest = $responseData['data'];
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

        AppUser::find(self::$userAuth['id'])->forceDelete();
        AppUser::withTrashed()->find(self::$userTest['id'])->forceDelete();
    }
}
