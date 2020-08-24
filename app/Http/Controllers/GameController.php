<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Http\Filters\GameFilter;
use App\Http\Requests\GameBookingRequest;
use App\Http\Requests\GameRequest;
use App\Imports\GameImport;
use App\Models\Bookmaker;
use App\Models\Game;
use App\Policies\AdminPolicy;
use App\Repositories\GameRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;

class GameController extends BaseController
{

    /** @var  GameRepository */
    private $gameRepo;

    public function __construct(GameRepository $gameRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->gameRepo = $gameRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param GameFilter $filter
     * @return Response
     */
    public function index(GameFilter $filter)
    {
        $games = $this->gameRepo->query($filter);

        return $this->sendSuccess($games->toArray(), 'Games retrieved successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return Response
     */
    public function show(Game $game)
    {
        return $this->sendSuccess($game->toArray(), 'Game retrieved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GameRequest $request
     * @return Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function store(GameRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $data = array_merge([
            'user_id' => auth()->user()->id,
            'game_number' => Helper::generateRandom(8)
        ], $request->validated());

        $game = $this->gameRepo->store($data);

        Excel::import(new GameImport($game->id),Request::file('file'));

        return $this->sendSuccess($game->fresh()->toArray(),'Game Created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GameRequest $request
     * @param Game $game
     * @return Response
     * @throws AuthorizationException
     */
    public function update(GameRequest $request, Game $game)
    {
        $this->authorize('update', AdminPolicy::class);
        $game = $this->gameRepo->update($game, $request->validated());

        return $this->sendSuccess($game->toArray(), 'Game updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Game $game)
    {
        $this->authorize('delete', AdminPolicy::class);
        $game->delete();

        return $this->sendSuccess([],'Game deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @param GameRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function manageOdds(Game $game, GameRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $game->odds()->sync($request->validated()['odds']);

        return $this->sendSuccess($game->fresh()->toArray(),'Odds Successfully updated');
    }
}
