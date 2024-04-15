<?php

namespace App\Http\Controllers;

use App\Annotations\Openapi;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use App\Models\FinancialExpense;

class FinancialExpenseController extends Controller
{
    #[Openapi\Param(['name' => 'page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'per_page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order_by', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order', 'in' => 'query'])]
    #[Openapi\Response(200, ['pagination' => 'object', 'data' => 'array'])]
    public function index(Request $request)
    {
        return FinancialExpense::searchPaginated($request);
    }

    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function store(Request $request)
    {
        return [
            'entity' => FinancialExpense::create($request->all()),
        ];
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function show($id, Request $request)
    {
        $entity = FinancialExpense::find($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        return ['entity' => $entity];
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function update(Request $request, $id)
    {
        $entity = FinancialExpense::find($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        return $entity->update($request->all());
    }

    #[Openapi\Param(['name' => 'id', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function destroy($id, Request $request)
    {
        $model = FinancialExpense::findOrFail($id);
        return $model->delete();
    }
}
