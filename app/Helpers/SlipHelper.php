<?php

namespace App\Helpers;

use App\Exceptions\CustomException;
use App\Models\Club;
use App\Models\Game;
use App\Models\GameItem;
use App\Models\Slip;
use App\Models\SlipItem;
use App\User;
use Illuminate\Support\Facades\DB;

class SlipHelper
{
    /**
     * @param Slip $slip
     * @param $id
     * @return Slip
     * @throws CustomException
     */
    public static function deleteItemFromSlip(Slip $slip, $id)
    {
        $itemFound = false;
        $id = trim($id);

        foreach ($slip->slipItems as $slipItem) {
            if ($slipItem->id == $id) {
                $itemFound = true;
                $slipItem->delete();
            }
        }

        if (!$itemFound) {
            throw new CustomException(ResponseMessages::ITEM_NOT_IN_SLIP, ResponseCodes::ITEM_NOT_IN_SLIP);
        }

        return $slip;
    }

    /**
     * @param Slip $slip
     * @param $data
     * @return array|bool
     */
    public static function modifyCartItem(Slip $slip, $data)
    {
        $slipItem = new SlipItem();

        if (!$slipItem) {
            return ['message' => ResponseMessages::ERROR_MODIFYING_SLIP, 'code' => ResponseCodes::ERROR_MODIFYING_SLIP];
        }

        $slipItem->match_date = $data['match_date'];
        $slipItem->competition_id = $data['competition_id'];
        $slipItem->odd_id = $data['odd_id'];
        $slipItem->home()->associate(Club::find($data['home']));
        $slipItem->away()->associate(Club::find($data['away']));
        $slipItem->slip_id = $slip->id;

        $slipItem->save();

        if (!$slipItem->id) {
            return ['message' => ResponseMessages::ERROR_MODIFYING_SLIP, 'code' => ResponseCodes::ERROR_MODIFYING_SLIP];
        }

        return true;
    }

    /**
     * @param Slip $slip
     * @param User $user
     * @return Slip
     * @throws \Exception
     */
    public static function mergeUserSlip(Slip $slip, User $user)
    {
        $userSlip = Slip::getLatestByUserId($user->id);

        if ($userSlip && $userSlip->id != $slip->id) {
            $slip = self::migrateSlip($userSlip, $slip);
        } elseif (!$slip->user) {
            $slip->user_id = $user->id;
            $slip->save();
        }

        return $slip;
    }

    /**
     * @param Slip $userExistingSlip
     * @param Slip $currentSlip
     * @return Slip|bool
     * @throws \Exception
     */
    private static function migrateSlip(Slip $userExistingSlip, Slip $currentSlip)
    {
        $userSlip = $currentSlip;
        if ($currentSlip->slipItems->isEmpty() && !$userExistingSlip->slipItems->isEmpty()){
            $request = app("request");
            $request->core_session->set("slip_id", $userExistingSlip->id);
            $userSlip = $userExistingSlip;
            self::deleteSlip($currentSlip, $userExistingSlip->user);
        }

        return $userSlip;
    }

    /**
     * @param Slip $slip
     * @param User $user
     * @param bool $returnNewSlip
     *
     * @return Slip|null
     * @throws \Exception
     */
    public static function deleteSlip(Slip $slip, User $user,
            $returnNewSlip = false)
    {
        if (!empty($slip)) {
            $slip = $slip->fresh('slipItems');
            $slip->slipItems()->delete();
            $slip->delete();
        }

        if ($returnNewSlip) {
            $slip = new Slip();
            $slip->user_id = $user->id;
            $slip->save();

            return $slip;
        }
    }


    /**
     * @param Slip $slip
     * @param $extra
     * @return Game
     * @throws \Exception
     */
    public static function convertSlipToGame(Slip $slip, $extra): Game
    {
        DB::beginTransaction();
        try {
            $gameObj = new Game();

            $game = Helper::classMerger($gameObj, $slip, ['user_id'], []);

            $game->game_number = Helper::generateRandom(8);
            $game->game_date = $extra['game_date'];
            $game->market_id = $extra['market_id'];

            $game->save();

            //Convert slipItems to GameItems
            $game = self::migrateSlipItemsToGameItems($slip, $game);
        } catch (\Exception $e) {
            LogHelper::error("Error while converting slip with Id: {$slip->id} to Game.", [
                'exceptionMessage' => $e->getMessage(),
                'stackTrace' => $e->getTrace()
            ]);
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return $game;
    }

    /**
     * @param Slip $slip
     * @param Game $game
     * @return Game
     * @throws \Exception
     */
    private static function migrateSlipItemsToGameItems(Slip $slip,
            Game $game): Game
    {
        foreach ($slip->slipItems as $slipItem) {
            $gameItem = Helper::classMerger(new GameItem(), $slipItem, ['match_date',
                        'home_type', 'home_id', 'away_type', 'away_id', 'competition_id', 'odd_id'], []
            );

            $game->gameItems()->save($gameItem);
        }

        return $game;
    }

    /**
     * @return Slip
     */
    public static function getSlip()
    {
        return Slip::getById(request()->core_session->get('slip_id'));
    }

    /**
     * @param Game $game
     * @param Slip $slip
     *
     * @return array
     */
    public static function reBet(Game $game, Slip $slip)
    {
        $gameItems = $game->gameItems;

        $errors = [];

        foreach ($gameItems as $gameItem) {

            try {
                self::modifySlip($slip->id, $gameItem, true);
            } catch (\Exception $e) {
                $errors[] = [
                    'match_date' => $gameItem->match_date,
                    'competition_id' => $gameItem->competition_id,
                    'odd_id' => $gameItem->odd_id,
                    'error_message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                ];
            }
        }

        return ['slip' => $slip, 'errors' => $errors];
    }

    /**
     * @param $slipId
     * @param $data
     * @param bool $mergeQty
     *
     * @return Slip
     * @throws CustomException
     */
    public static function modifySlip($slipId, $data, $mergeQty = false)
    {
        $slip = Slip::getById($slipId);

        $response = self::modifyCartItem($slip, $data);
        if (is_array($response)) {
            throw new CustomException($response['message'], $response['code'], $response);
        }

        return $slip;
    }

    /**
     * Merges the current user slip.
     *
     * @param User $user
     * @return Slip
     * @throws \Exception
     */
    public static function mergeCurrentSlip(User $user)
    {
        $request = request();
        $slip = self::mergeUserSlip(Slip::getById($request->core_session->get('slip_id')), $user);
        $request->core_session->set('slip_id', $slip->id);
        return $slip;
    }
}
