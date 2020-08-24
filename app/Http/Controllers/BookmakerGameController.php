<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Http\Requests\GameBookingRequest;
use App\Models\Bookmaker;
use App\Models\Game;
use Illuminate\Http\Response;

class BookmakerGameController extends BaseController
{
    /**
     * @param Game $game
     * @param Bookmaker $bookmaker
     * @param GameBookingRequest $request
     * @return Response
     */
    public function addBooking(Game $game, Bookmaker $bookmaker,  GameBookingRequest $request)
    {
        try {
            $game->bookmakers()->sync([$bookmaker->id => $request->validated()], false);
            return $this->sendSuccess($game->fresh()->toArray(), ResponseMessages::ACTION_SUCCESSFUL);
        } catch (\Exception $e) {
            return $this->sendError(
                $e->getMessage(), ResponseCodes::UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * @param Game $game
     * @param Bookmaker $bookmaker
     * @return Response
     */
    public function removeBooking(Game $game, Bookmaker $bookmaker)
    {
        try {
            $game->bookmakers()->detach($bookmaker);
            return $this->sendSuccess($game->fresh()->toArray(), ResponseMessages::ACTION_SUCCESSFUL);
        } catch (\Exception $e) {
            return $this->sendError(
                $e->getMessage(), ResponseCodes::UNPROCESSABLE_ENTITY
            );
        }
    }
}
