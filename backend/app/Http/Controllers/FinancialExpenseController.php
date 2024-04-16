<?php

namespace App\Http\Controllers;

use App\Annotations\Openapi;
use App\Contracts\FinancialExpenseRepositoryInterface;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use App\Models\FinancialExpense;
use App\Http\Requests\FinancialExpenseRequest;
use App\Http\Resources\FinancialExpenseResource;

class FinancialExpenseController extends Controller
{
    public function __construct(private FinancialExpenseRepositoryInterface $repository)
    {
    }

    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'per_page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order_by', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order', 'in' => 'query'])]
    #[Openapi\Response(200, ['pagination' => 'object', 'data' => 'array'])]
    public function index(Request $request)
    {
        return $this->repository->index($request);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function store(FinancialExpenseRequest $request)
    {
        $entity = $this->repository->store($request);
        return new FinancialExpenseResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'financial_expense', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function show($id, Request $request)
    {
        $entity = $this->repository->show($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        if ($request->user()->cannot('show', $entity)) {
            throw new ApiError(403, 'Sem permissão');
        }
        return new FinancialExpenseResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'financial_expense', 'in' => 'path'])]
    #[Openapi\Param(['name' => 'description', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'date', 'in' => 'body', 'type' => 'string', 'format' => 'date-time'])]
    #[Openapi\Param(['name' => 'user_id', 'in' => 'body', 'type' => 'number', 'format' => 'int32'])]
    #[Openapi\Param(['name' => 'amount', 'in' => 'body', 'type' => 'number', 'format' => 'double'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function update(FinancialExpenseRequest $request, $id)
    {
        $entity = $this->repository->update($request, $id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        if ($request->user()->cannot('update', $entity)) {
            throw new ApiError(403, 'Sem permissão');
        }
        return new FinancialExpenseResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'financial_expense', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function destroy($id, Request $request)
    {
        $entity = $this->repository->destroy($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        if ($request->user()->cannot('update', $entity)) {
            throw new ApiError(403, 'Sem permissão');
        }
        $entity->delete();
        return new FinancialExpenseResource($entity);
    }
}
