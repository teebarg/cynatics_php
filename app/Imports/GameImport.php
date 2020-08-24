<?php

namespace App\Imports;


use App\Models\Club;
use App\Models\Competition;
use App\Models\GameItem;
use App\Models\Odd;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GameImport implements ToModel, WithHeadingRow
{
    /**
     * @var int
     */
    private $gameId;

    /**
     * GameImport constructor.
     * @param int $gameId
     */
    public function __construct(int $gameId)
    {

        $this->gameId = $gameId;
    }

    /**
    * @param array $row
    *
    * @return GameItem
    */
    public function model(array $row)
    {
        $data = $this->process($row);
        $gameItem = new GameItem();
        $gameItem->match_date = $this->transformDate($row['match_date']);
        $gameItem->competition_id = $data['competition'];
        $gameItem->odd_id = $data['odd'];
        $gameItem->home()->associate(Club::find($data['home']));
        $gameItem->away()->associate(Club::find($data['away']));
        $gameItem->game_id = $this->gameId;

        $gameItem->save();

        return $gameItem;
    }

    private function process($row)
    {
        $data = [];
        $data['home'] = $this->getId(Club::class, $row['home']);
        $data['away'] = $this->getId(Club::class, $row['away']);
        $data['competition'] = $this->getId(Competition::class, $row['competition']);
        $data['odd'] = $this->getId(Odd::class, $row['odd']);

        return $data;
    }

    private function getId($model, $value)
    {
        return $model::where('name', 'like', '%' . $value . '%')->first()->id ?? $model::first()->id;
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @param $value
     * @param string $format
     * @return Carbon|null
     */
    public function transformDate($value, $format = 'm-d-Y')
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }
}
