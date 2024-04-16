<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Annotations\Openapi;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use App\Http\Resources\AppUserResource;
use App\Http\Requests\AppUserCreateRequest;
use App\Http\Requests\AppUserUpdateRequest;
use App\Contracts\AppUserRepositoryInterface;

class AppUserController extends Controller
{
    public function __construct(private AppUserRepositoryInterface $repository)
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
    #[Openapi\Param(['name' => 'name', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'email', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'password', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function store(AppUserCreateRequest $request)
    {
        $entity = $this->repository->store($request);
        return new AppUserResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'app_user', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function show($id, Request $request)
    {
        $entity = $this->repository->show($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        return new AppUserResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'app_user', 'in' => 'path'])]
    #[Openapi\Param(['name' => 'name', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'email', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'password', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function update(AppUserUpdateRequest $request, $id)
    {
        $entity = $this->repository->update($request, $id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        $entity->update($request->all());
        return new AppUserResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'app_user', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function destroy($id, Request $request)
    {
        $entity = $this->repository->destroy($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        $entity->delete();
        return new AppUserResource($entity);
    }
}
