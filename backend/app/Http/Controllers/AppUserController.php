<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Annotations\Openapi;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use App\Http\Requests\AppUserCreateRequest;
use App\Http\Requests\AppUserUpdateRequest;
use App\Http\Resources\AppUserResource;

class AppUserController extends Controller
{
    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'per_page', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order_by', 'in' => 'query'])]
    #[Openapi\Param(['name' => 'order', 'in' => 'query'])]
    #[Openapi\Response(200, ['pagination' => 'object', 'data' => 'array'])]
    public function index(Request $request)
    {
        return AppUser::searchPaginated($request);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'name', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'email', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Param(['name' => 'password', 'in' => 'body', 'type' => 'string'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function store(AppUserCreateRequest $request)
    {
        $entity = AppUser::create($request->all());
        return new AppUserResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'app_user', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function show($id, Request $request)
    {
        $entity = AppUser::find($id);
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
        $entity = AppUser::find($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        $entity->update($request->all());
        return new AppUserResource($entity);
    }


    #[Openapi\Auth()]
    #[Openapi\Param(['name' => 'app_user', 'in' => 'path'])]
    #[Openapi\Response(200, ['entity' => 'object'])]
    public function destroy($id, Request $request)
    {
        $entity = AppUser::find($id);
        if (!$entity) throw new ApiError(404, 'Entity not found');
        $entity->delete();
        return new AppUserResource($entity);
    }
}
