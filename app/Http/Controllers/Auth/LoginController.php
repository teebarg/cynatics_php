<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Helpers\SlipHelper;
use App\Http\Controllers\Controller;
use App\Models\Slip;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (! $token = auth()->attempt($this->credentials($request))) {
            return false;
        }
        JWTAuth::setToken($token);
        return true;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            $request->core_session->set('is_logged_in', 1);
//            dd($this->guard()->user());

            // Merge created slip with existing cart or merge current cart to user.
            if (isset($request->core_session->slip_id)) {
                $slip = SlipHelper::mergeUserSlip(
                    Slip::getById($request->core_session->get('slip_id'))
                    , $this->guard()->user()
                );
                $request->core_session->set('slip_id', $slip->id);
            }

            return ResponseHelper::createSuccessResponse(['data' => [
                'token' => $token
            ]], 'Successfully Logged In');
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->core_session->unsetKey('is_logged_in');
        $request->core_session->unsetKey('slip_id');
        return ResponseHelper::createSuccessResponse([], 'Successfully Logged Out');
    }
}
