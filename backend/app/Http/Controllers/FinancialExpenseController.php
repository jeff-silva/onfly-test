<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Annotations\Openapi;

class FinancialExpenseController extends Controller
{
    #[Openapi\Param(['name' => 'page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'per_page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order_by', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order', 'in' => 'query'])]
    public function index()
    {
        return 'index';
    }

    #[Openapi\Param(['name' => 'description', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body'])]
    public function store()
    {
        return 'store';
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    public function show()
    {
        return 'show';
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    #[Openapi\Param(['name' => 'description', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body'])]
    public function update()
    {
        return 'update';
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    public function destroy()
    {
        return 'destroy';
    }
}
