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

    public function store()
    {
        return 'store';
    }

    public function show()
    {
        return 'show';
    }

    public function update()
    {
        return 'update';
    }

    public function destroy()
    {
        return 'destroy';
    }
}
