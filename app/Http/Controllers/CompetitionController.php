<?php

namespace App\Http\Controllers;

use App\Http\Filters\CompetitionFilter;
use App\Http\Requests\CompetitionRequest;
use App\Models\Competition;
use App\Policies\AdminPolicy;
use App\Repositories\CompetitionRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class CompetitionController
 * @package App\Http\Controllers
 */

class CompetitionController extends BaseController
{
    /** @var  CompetitionRepository */
    private $competitionRepository;

    public function __construct(CompetitionRepository $competitionRepo)
    {
        $this->competitionRepository = $competitionRepo;
    }

    /**
     *
     * @param CompetitionFilter $filter
     * @return Response
     */
    public function index(CompetitionFilter $filter)
    {
        $competitions = $this->competitionRepository->query($filter);

        return $this->sendSuccess($competitions->toArray(), 'Competitions retrieved successfully');
    }

    /**
     * @param CompetitionRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function store(CompetitionRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $competition = $this->competitionRepository->store($request->validated());

        return $this->sendSuccess($competition->toArray(), 'Competition saved successfully');
    }

    /**
     * @param Competition $competition
     * @return Response
     */
    public function show(Competition $competition)
    {
        return $this->sendSuccess($competition->toArray(), 'Competition retrieved successfully');
    }

    /**
     * @param Competition $competition
     * @param CompetitionRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Competition $competition, CompetitionRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $competition = $this->competitionRepository->update($competition, $request->validated());

        return $this->sendSuccess($competition->fresh()->toArray(), 'Competition updated successfully');
    }

    /**
     * @param Competition $competition
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Competition $competition)
    {
//        $this->authorize('delete', AdminPolicy::class);
        $competition->delete();

        return $this->sendSuccess([],'Competition deleted successfully');
    }
}
