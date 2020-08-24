<?php

namespace App\Http\Controllers;

use App\Http\Filters\MarketFilter;
use App\Http\Requests\MarketRequest;
use App\Models\Market;
use App\Policies\AdminPolicy;
use App\Repositories\MarketRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class MarketController
 * @package App\Http\Controllers
 */

class MarketController extends BaseController
{
    /** @var  MarketRepository */
    private $marketRepo;

    public function __construct(MarketRepository $marketRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->marketRepo = $marketRepository;
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendSuccess(Market::all()->toArray(), 'Markets retrieved successfully');
    }

    /**
     * Store a newly created Market in storage.
     * POST /countries
     *
     *
     * @param MarketRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(MarketRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $market = $this->marketRepo->store($request->validated());

        return $this->sendSuccess($market->toArray(), 'Market saved successfully');
    }

    /**
     * @param Market $market
     * @return Response
     */
    public function show(Market $market)
    {
        return $this->sendSuccess($market->toArray(), 'Market retrieved successfully');
    }

    /**
     * @param Market $market
     * @param MarketRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Market $market, MarketRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $market = $this->marketRepo->update($market, $request->validated());

        return $this->sendSuccess($market->toArray(), 'Market updated successfully');
    }

    /**
     * @param Market $market
     * @return Response
     * @throws \Exception
     */
    public function destroy(Market $market)
    {
        $this->authorize('delete', AdminPolicy::class);
        $market->delete();

        return $this->sendSuccess([],'Market deleted successfully');
    }
}
