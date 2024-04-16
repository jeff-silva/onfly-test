<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AppUser;
use App\Models\FinancialExpense;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinancialExpenseTest extends TestCase
{
    static $requestHeaders = [];
    static $expense = [];

    public function test_validations(): void
    {
        $token = JWTAuth::fromUser(AppUser::find(1));
        self::$requestHeaders = ['Authorization' => "Bearer {$token}"];

        $response = $this->json('POST', '/api/financial_expense', [], self::$requestHeaders);
        $response->assertJsonStructure(['errors' => ['user_id', 'description', 'date', 'amount']]);
        $response->assertStatus(422);
    }

    public function test_create(): void
    {
        self::$expense = [
            'user_id' => 1,
            'description' => 'Expense test',
            'date' => now()->subDays(3)->format('Y-m-d H:i:s'),
            'amount' => 123.45,
        ];

        $response = $this->json('POST', '/api/financial_expense', self::$expense, self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertStatus(201);

        $responseData = json_decode($response->getContent(), true);
        self::$expense['id'] = $responseData['data']['id'];
    }

    public function test_update()
    {
        self::$expense['description'] = 'Foo';
        $response = $this->json('PUT', '/api/financial_expense/' . self::$expense['id'], self::$expense, self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertJsonPath('data.description', 'Foo');
    }

    public function test_delete()
    {
        $response = $this->json('DELETE', '/api/financial_expense/' . self::$expense['id'], [], self::$requestHeaders);
        $response->assertJsonStructure(['data']);
        $response->assertStatus(200);
        FinancialExpense::withTrashed()->find(self::$expense['id'])->forceDelete();
    }
}
