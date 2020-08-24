<?php

namespace App\Http\Controllers;

use App\Http\Filters\GameItemFilter;
use App\Http\Requests\GameItemRequest;
use App\Models\GameItem;
use App\Policies\AdminPolicy;
use App\Repositories\GameItemRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class GameItemController extends BaseController
{
    /** @var  GameItemRepository */
    private $gameItemRepo;

    public function __construct(GameItemRepository $gameItemRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->gameItemRepo = $gameItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param GameItemFilter $filter
     * @return Response
     */
    public function index(GameItemFilter $filter)
    {
        $gameItems = $this->gameItemRepo->query($filter);

        return $this->sendSuccess($gameItems->toArray(), 'Game Items Items retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GameItemRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(GameItemRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $gameItem = $this->gameItemRepo->store($request->validated());

        return $this->sendSuccess($gameItem->toArray(), 'Game Item Added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GameItemRequest $request
     * @param GameItem $gameItem
     * @return Response
     * @throws AuthorizationException
     */
    public function update(GameItemRequest $request, GameItem $gameItem)
    {
        $this->authorize('update', AdminPolicy::class);
        $gameItem = $this->gameItemRepo->update($gameItem, $request->validated());

        return $this->sendSuccess($gameItem->toArray(), 'Game Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GameItem $gameItem
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(GameItem $gameItem)
    {
        $this->authorize('delete', AdminPolicy::class);
        $gameItem->delete();

        return $this->sendSuccess([],'Game Item deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GameItem $gameItem
     * @param GameItemRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function manageOdds(GameItem $gameItem, GameItemRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $gameItem->odds()->sync($request->validated()['odds']);

        return $this->sendSuccess($gameItem->fresh()->toArray(),'Odds Successfully updated');
    }
}
