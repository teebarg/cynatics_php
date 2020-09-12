<?php

namespace App\Http\Controllers;

use App\Http\Filters\AdSlotFilter;
use App\Http\Requests\AdSlotRequest;
use App\Models\AdSlot;
use App\Policies\AdminPolicy;
use App\Repositories\AdSlotRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class AdSlotController extends BaseController
{

    /** @var  AdSlotRepository */
    private $adSlotRepo;

    public function __construct(AdSlotRepository $adSlotRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->adSlotRepo = $adSlotRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param AdSlotFilter $filter
     * @return Response
     */
    public function index(AdSlotFilter $filter)
    {
        $games = $this->adSlotRepo->query($filter);

        return $this->sendSuccess($games->toArray(), 'AdSlot retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdSlotRequest $request
     * @param AdSlot $ad_slot
     * @return Response
     * @throws AuthorizationException
     */
    public function update(AdSlotRequest $request, AdSlot $ad_slot)
    {
        $this->authorize('update', AdminPolicy::class);
        $ad_slot = $this->adSlotRepo->update($ad_slot, $request->validated());

        return $this->sendSuccess($ad_slot->toArray(), 'AdSlot updated successfully');
    }
}
