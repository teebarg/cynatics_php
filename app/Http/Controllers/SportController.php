<?php

namespace App\Http\Controllers;

use App\Http\Requests\SportRequest;
use App\Models\Sport;
use App\Repositories\SportRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

/**
 * Class SportController
 * @package App\Http\Controllers
 */

class SportController extends BaseController
{
    /** @var  SportRepository */
    private $sportRepo;

    public function __construct(SportRepository $sportRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->sportRepo = $sportRepository;
    }

    /**
     * @return Response
     */
    public function index(Request $request)
    {
//        $request->core_session->set("cart_id", ['kd' => 1, 'sss' => 23]);
//        dd(request('core_session'));
//        dd($request->core_session);
//        $request->session()->set_session = 'MaAovEmcXjdc4r78b8tlYcOcC8I3y8MHTezFmw4W';
//        session(['beaff' => 256]);
//        Redis::set('beaf', 'Taylor');
//        dump($request->session()->get('beaff'));

//        dump(Redis::get('beaf'));
//        dd($request->session()->all());
        $sports = $this->sportRepo->all();

        return $this->sendSuccess($sports->toArray(), 'Sports retrieved successfully');
    }

    /**
     * Store a newly created Sport in storage.
     * POST /countries
     *
     *
     * @param SportRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(SportRequest $request)
    {
//        $this->authorize('create', Sport::class);
        $sport = $this->sportRepo->store($request->validated());

        return $this->sendSuccess($sport->toArray(), 'Sport saved successfully');
    }

    /**
     * @param Sport $sport
     * @return Response
     */
    public function show(Sport $sport)
    {
        return $this->sendSuccess($sport->toArray(), 'Sport retrieved successfully');
    }

    /**
     * @param Sport $sport
     * @param SportRequest $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Sport $sport, SportRequest $request)
    {
        $this->authorize('update', Sport::class);
        $sport = $this->sportRepo->update($sport, $request->validated());

        return $this->sendSuccess($sport->toArray(), 'Sport updated successfully');
    }

    /**
     * @param Sport $sport
     * @return Response
     * @throws \Exception
     */
    public function destroy(Sport $sport)
    {
        $this->authorize('delete', Sport::class);
        $sport->delete();

        return $this->sendSuccess([],'Sport deleted successfully');
    }
}
