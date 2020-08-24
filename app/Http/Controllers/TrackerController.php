<?php

namespace App\Http\Controllers;

use App\Policies\AdminPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use PragmaRX\Tracker\Vendor\Laravel\Facade as tracker;

class TrackerController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return Response
     */
    public function visitor()
    {
        $visitor = Tracker::currentSession();

        return $this->sendSuccess($visitor->toArray(), 'Visitor retrieved successfully');
    }

    /**
     * @return Response
     * @throws AuthorizationException
     */
    public function session()
    {
        $this->authorize('create', AdminPolicy::class);
        $sessions = Tracker::sessions(60 * 24); // get sessions (visits) from the past day

        return $this->sendSuccess($sessions->toArray(), 'Session retrieved successfully');
    }
}
