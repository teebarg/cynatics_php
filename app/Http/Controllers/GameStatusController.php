<?php

namespace App\Http\Controllers;

use App\Models\GameStatus;
use Illuminate\Http\Response;

class GameStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendSuccess(GameStatus::all()->toArray(), 'Game Status retrieved successfully');
    }
}
