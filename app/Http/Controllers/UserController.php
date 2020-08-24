<?php

namespace App\Http\Controllers;

use App\Events\CreatedUser;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Policies\AdminPolicy;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UserController
 * @package App\Http\Controllers
 */

class UserController extends BaseController
{
    /** @var  UserRepository */
    private $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->userRepo = $userRepository;
    }

    /**
     *
     * @param UserFilter $userFilter
     * @return Response
     */
    public function index(UserFilter $userFilter)
    {
        $users = $this->userRepo->query($userFilter);

        return $this->sendSuccess($users->toArray(), 'Users retrieved successfully');
    }

    /**
     *
     * @param UserRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $user = $this->userRepo->store($request->validated());
//        event(new CreatedUser($user));

        return $this->sendSuccess($user->toArray(), 'User saved successfully');
    }

    /**
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return $this->sendSuccess($user->toArray(), 'User retrieved successfully');
    }

    /**
     * @param User $user
     * @param UserRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(User $user, UserRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $user = $this->userRepo->update($user, $request->validated());

        return $this->sendSuccess($user->fresh()->toArray(), 'User updated successfully');
    }

    /**
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', AdminPolicy::class);
        $user->delete();

        return $this->sendSuccess([],'User deleted successfully');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function manageRoles(User $user, Request $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $user->syncRoles($request->input('roles'));

        return $this->sendSuccess($user->fresh()->toArray(),'User Role Successfully updated');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function managePermissions(User $user, Request $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $user->syncPermissions($request->input('permissions'));

        return $this->sendSuccess($user->fresh()->toArray(),'User Permission Successfully updated');
    }
}
