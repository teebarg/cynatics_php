<?php

namespace App\Http\Controllers;

use App\Http\Filters\RoleFilter;
use App\Http\Requests\RoleRequest;
use App\Policies\AdminPolicy;
use App\Repositories\RoleRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    /** @var  RoleRepository */
    private $roleRepo;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->roleRepo = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $roles = $this->roleRepo->all();
        return $this->sendSuccess($roles->toArray(), 'Roles retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     * @throws AuthorizationException
     */   public function store(RoleRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $role = $this->roleRepo->store($request->validated());

        return $this->sendSuccess($role->toArray(), 'Role saved successfully');
    }

    /**
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        return $this->sendSuccess($role->toArray(), 'Role retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @param RoleRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Role $role, RoleRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $role = $this->roleRepo->update($role, $request->validated());

        return $this->sendSuccess($role->toArray(), 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', AdminPolicy::class);
        $role->delete();

        return $this->sendSuccess([],'Role deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function managePermissions(Role $role, Request $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $role->syncPermissions($request->input('permissions'));

        return $this->sendSuccess($role->fresh()->toArray(),'Permission added Successfully successfully');
    }
}
