<?php

namespace App\Http\Controllers;

use App\Http\Filters\OddFilter;
use App\Http\Requests\OddRequest;
use App\Models\Odd;
use App\Policies\AdminPolicy;
use App\Repositories\OddRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class OddController
 * @package App\Http\Controllers
 */

class OddController extends BaseController
{
    /** @var  OddRepository */
    private $oddRepo;

    public function __construct(OddRepository $oddRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->oddRepo = $oddRepository;
    }

    /**
     *
     * @param OddFilter $filter
     * @return Response
     */
    public function index(OddFilter $filter)
    {
        $clubs = $this->oddRepo->query($filter);

        return $this->sendSuccess($clubs->toArray(), 'Clubs retrieved successfully');
    }

    /**
     * Store a newly created Odd in storage.
     * POST /countries
     *
     *
     * @param OddRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(OddRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $odd = $this->oddRepo->store($request->validated());

        return $this->sendSuccess($odd->toArray(), 'Odd saved successfully');
    }

    /**
     * @param Odd $odd
     * @return Response
     */
    public function show(Odd $odd)
    {
        return $this->sendSuccess($odd->toArray(), 'Odd retrieved successfully');
    }

    /**
     * @param Odd $odd
     * @param OddRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Odd $odd, OddRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $odd = $this->oddRepo->update($odd, $request->validated());

        return $this->sendSuccess($odd->toArray(), 'Odd updated successfully');
    }

    /**
     * @param Odd $odd
     * @return Response
     * @throws \Exception
     */
    public function destroy(Odd $odd)
    {
        $this->authorize('delete', AdminPolicy::class);
        $odd->delete();

        return $this->sendSuccess([],'Odd deleted successfully');
    }
}
