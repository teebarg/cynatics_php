<?php

namespace App\Http\Controllers;

use App\Http\Filters\ClubFilter;
use App\Http\Requests\ClubRequest;
use App\Models\Club;
use App\Policies\AdminPolicy;
use App\Repositories\ClubRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class ClubController
 * @package App\Http\Controllers
 */

class ClubController extends BaseController
{
    /** @var  ClubRepository */
    private $clubRepo;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->clubRepo = $clubRepository;
    }

    /**
     *
     * @param ClubFilter $clubFilter
     * @return Response
     */
    public function index(ClubFilter $clubFilter)
    {
        $clubs = $this->clubRepo->query($clubFilter);

        return $this->sendSuccess($clubs->toArray(), 'Clubs retrieved successfully');
    }

    /**
     * Store a newly created Club in storage.
     * POST /countries
     *
     *
     * @param ClubRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(ClubRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $club = $this->clubRepo->store($request->validated());

        return $this->sendSuccess($club->toArray(), 'Club saved successfully');
    }

    /**
     * @param Club $club
     * @return Response
     */
    public function show(Club $club)
    {
        return $this->sendSuccess($club->toArray(), 'Club retrieved successfully');
    }

    /**
     * @param Club $club
     * @param ClubRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Club $club, ClubRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $club = $this->clubRepo->update($club, $request->validated());

        return $this->sendSuccess($club->fresh()->toArray(), 'Club updated successfully');
    }

    /**
     * @param Club $club
     * @return Response
     * @throws \Exception
     */
    public function destroy(Club $club)
    {
        $this->authorize('delete', AdminPolicy::class);
        $club->delete();

        return $this->sendSuccess([],'Club deleted successfully');
    }

    /**
     * @param Club $club
     * @param ClubRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function manageCompetitions(Club $club, ClubRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $club->competitions()->sync($request->validated()['competitions']);

        return $this->sendSuccess([],'Competitions Successfully updated');
    }
}
