<?php


namespace App\Services;


use App\Models\AdSlot;
use App\Models\Game;

class HomeService
{

    public function getHomeData(){
        $data['free'] = $this->getGames(Game::FREE)[0] ?? [];
        $data['premium'] = $this->getGames(Game::PREMIUM)[0] ?? [];
        $data['latest'] = $this->getTop();
        $data['banners'] = $this->getAds('banner');
//        dd($data['free']);
        return $data;
    }

    public function getGames($market){
        return Game::whereHas('market', function ($query) use ($market) {
            $query->where('slug', 'like', '%' . $market . '%');
        })->get();
    }

    public function getTop(){
       return Game::orderBy('created_at')->take(4)->get();
    }

    public function getAds(string $name){
        return AdSlot::with(['adverts' => function ($query) {
            $query->where('is_active', 1);
        }])->where('name', $name)->get();
    }
}
