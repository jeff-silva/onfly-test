<?php

namespace App\Http\Controllers;

use App\Annotations\Openapi;
use Illuminate\Http\Request;
use App\Models\FinancialExpense;

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

    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    public function store(Request $request)
    {
        return FinancialExpense::create($request->all());
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    public function show($id, Request $request)
    {
        return FinancialExpense::findOrFail($id);
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    public function update(Request $request, $id)
    {
        $model = FinancialExpense::findOrFail($id);
        return $model->update($request->all());
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    public function destroy($id, Request $request)
    {
        $model = FinancialExpense::findOrFail($id);
        return $model->delete();
    }
}
