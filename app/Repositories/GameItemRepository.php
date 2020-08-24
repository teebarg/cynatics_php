<?php

namespace App\Repositories;

use App\Models\Club;
use App\Models\GameItem;

/**
 * Class GameRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class GameItemRepository extends Repository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return GameItem::class;
    }

    public function store($data) {
        $gameItem = new GameItem();

        $gameItem->game_id = $data['game_id'];
        $gameItem->match_date = $data['match_date'];
        $gameItem->competition_id = $data['competition_id'];
        $gameItem->odd_id = $data['odd_id'];
        $gameItem->home()->associate(Club::find($data['home_id']));
        $gameItem->away()->associate(Club::find($data['away_id']));

        $gameItem->save();
        return $gameItem->fresh();
    }
}
