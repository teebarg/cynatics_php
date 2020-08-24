<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Policies\AdminPolicy;
use App\Repositories\PermissionRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    /** @var  PermissionRepository */
    private $permissionRepo;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->permissionRepo = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = $this->permissionRepo->all();
        return $this->sendSuccess($permissions->toArray(), 'Permissions retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $permission = $this->permissionRepo->store($request->validated());

        return $this->sendSuccess($permission->toArray(), 'Permission saved successfully');
    }

    /**
     * @param Permission $permission
     * @return Response
     */
    public function show(Permission $permission)
    {
        return $this->sendSuccess($permission->toArray(), 'Permission retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Permission $permission
     * @param PermissionRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Permission $permission, PermissionRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $permission = $this->permissionRepo->update($permission, $request->validated());

        return $this->sendSuccess($permission->toArray(), 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', AdminPolicy::class);
        $permission->delete();

        return $this->sendSuccess([],'Permission deleted successfully');
    }
}
