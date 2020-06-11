<?php

namespace App\Http\Controllers;

use App\Business;
use App\Http\Filters\BusinessFilter;
use App\Http\Requests\CreateBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Repositories\BusinessRepository;
use Illuminate\Http\Response;

class BusinessController extends BaseController
{
    /** @var  BusinessRepository */
    private $businessRepository;

    public function __construct(BusinessRepository $businessRepo)
    {
        $this->businessRepository = $businessRepo;
    }

    /**
     *
     * @param BusinessFilter $businessFilter
     * @return Response
     */
    public function index(BusinessFilter $businessFilter)
    {
        $businesses = $this->businessRepository->getAll($businessFilter);

        return $this->sendSuccess($businesses->toArray(), 'Businesses retrieved successfully');
    }

    /**
     *
     * @param CreateBusinessRequest $request
     * @return Response|Response
     */
    public function store(CreateBusinessRequest $request)
    {
        $business = $this->businessRepository->store($input = $request->all());

        return $this->sendSuccess($business->toArray(), 'Business saved successfully');
    }

    /**
     * Display the specified Business.
     *
     * @param Business $business
     * @return Response|Response
     */
    public function show(Business $business)
    {
        $business->increment('views');
        return $this->sendSuccess($business->toArray(), 'Business retrieved successfully');
    }

    /**
     *
     * @param Business $business
     * @param UpdateBusinessRequest $request
     *
     * @return Response
     */
    public function update(Business $business, UpdateBusinessRequest $request)
    {
        $business = $this->businessRepository->update($business, $request->all());

        return $this->sendSuccess($business->toArray(), 'Business updated successfully');
    }

    /**
     *
     * @param Business $business
     * @return Response
     * @throws \Exception
     */
    public function destroy(Business $business)
    {
        $business->delete();

        return $this->sendSuccess([], 'Business deleted successfully');
    }

}
