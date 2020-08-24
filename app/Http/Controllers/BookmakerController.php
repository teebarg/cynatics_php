<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmakerRequest;
use App\Models\Bookmaker;
use App\Policies\AdminPolicy;
use App\Repositories\BookmakerRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class BookmakerController extends BaseController
{
    /** @var  BookmakerRepository */
    private $bookmakerRepo;

    public function __construct(BookmakerRepository $bookmakerRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->bookmakerRepo = $bookmakerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bookings = $this->bookmakerRepo->all();

        return $this->sendSuccess($bookings->toArray(), 'Bookmakers retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookmakerRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(BookmakerRequest $request)
    {
        $this->authorize('create', AdminPolicy::class);
        $club = $this->bookmakerRepo->store($request->validated());

        return $this->sendSuccess($club->toArray(), 'Bookmaker saved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookmakerRequest $request
     * @param Bookmaker $bookmaker
     * @return Response
     * @throws AuthorizationException
     */
    public function update(BookmakerRequest $request, Bookmaker $bookmaker)
    {
        $this->authorize('update', AdminPolicy::class);
        $bookmaker = $this->bookmakerRepo->update($bookmaker, $request->validated());

        return $this->sendSuccess($bookmaker->toArray(), 'Bookmaker updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bookmaker $bookmaker
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Bookmaker $bookmaker)
    {
        $this->authorize('delete', AdminPolicy::class);
        $bookmaker->delete();

        return $this->sendSuccess([],'Bookmaker deleted successfully');
    }
}
