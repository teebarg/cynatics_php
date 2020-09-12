<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Response;

class HomeController extends BaseController
{
    /**
     * @var HomeService
     */
    private $homeService;

    /**
     * Create a new controller instance.
     *
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
//        $this->middleware('auth');
        $this->homeService = $homeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->homeService->getHomeData();
        return $this->sendSuccess($result, 'Items retrieved successfully');
    }
}
