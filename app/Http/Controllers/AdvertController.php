<?php

namespace App\Http\Controllers;

use App\Http\Filters\AdvertFilter;
use App\Http\Requests\AdvertRequest;
use App\Models\Advert;
use App\Policies\AdminPolicy;
use App\Repositories\AdvertRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class AdvertController
 * @package App\Http\Controllers
 */

class AdvertController extends BaseController
{
    /** @var  AdvertRepository */
    private $advertRepo;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->advertRepo = $advertRepository;
    }

    /**
     *
     * @param AdvertFilter $filter
     * @return Response
     */
    public function index(AdvertFilter $filter)
    {
        $clubs = $this->advertRepo->query($filter);

        return $this->sendSuccess($clubs->toArray(), 'Adverts retrieved successfully');
    }

    /**
     * Store a newly created Advert in storage.
     * POST /countries
     *
     *
     * @param AdvertRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(AdvertRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $advert = $this->advertRepo->store($request->validated());

        return $this->sendSuccess($advert->toArray(), 'Advert saved successfully');
    }

    /**
     * @param Advert $advert
     * @param AdvertRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Advert $advert, AdvertRequest $request)
    {
        $this->authorize('update', AdminPolicy::class);
        $advert = $this->advertRepo->update($advert, $request->validated());

        return $this->sendSuccess($advert->fresh()->toArray(), 'Advert updated successfully');
    }

    /**
     * @param Advert $advert
     * @return Response
     * @throws \Exception
     */
    public function destroy(Advert $advert)
    {
        $this->authorize('delete', AdminPolicy::class);
        $advert->delete();

        return $this->sendSuccess([],'Advert deleted successfully');
    }
}
