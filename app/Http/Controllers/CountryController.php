<?php

namespace App\Http\Controllers;

use App\Http\Filters\CountryFilter;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

/**
 * Class CountryController
 * @package App\Http\Controllers
 */

class CountryController extends BaseController
{
    /** @var  CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->countryRepository = $countryRepo;
    }

    /**
     *
     * @param CountryFilter $filter
     * @return Response
     */
    public function index(CountryFilter $filter)
    {
        $countries = $this->countryRepository->query($filter);

        return $this->sendSuccess($countries->toArray(), 'Countries retrieved successfully');
    }

    /**
     * Store a newly created Country in storage.
     * POST /countries
     *
     *
     * @param CountryRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(CountryRequest $request)
    {
        $this->authorize('create', Country::class);
        $country = $this->countryRepository->store($request->validated());

        return $this->sendSuccess($country->toArray(), 'Country saved successfully');
    }

    /**
     * @param Country $country
     * @return Response
     */
    public function show(Country $country)
    {
        return $this->sendSuccess($country->toArray(), 'Country retrieved successfully');
    }

    /**
     * @param Country $country
     * @param CountryRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Country $country, CountryRequest $request)
    {
        $this->authorize('update', Country::class);
        $country = $this->countryRepository->update($country, $request->validated());

        return $this->sendSuccess($country->toArray(), 'Country updated successfully');
    }

    /**
     * @param Country $country
     * @return Response
     * @throws \Exception
     */
    public function destroy(Country $country)
    {
        $this->authorize('delete', Country::class);
        $country->delete();

        return $this->sendSuccess([],'Country deleted successfully');
    }
}
