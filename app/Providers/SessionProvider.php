<?php

namespace App\Providers;

use App\Exceptions\CustomException;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Http\Requests\Request;
use App\Models\Session;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class SessionProvider extends ServiceProvider
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws CustomException
     */
    public function boot()
    {
        $this->setSession();
        $this->setCoreSession();
    }

    /**
     * @throws CustomException
     * @throws BindingResolutionException
     */
    protected function setSession()
    {
        $this->request = $this->app->make("request");

        if($this->request->has("session_id")){
            $sessionIdKey = $this->request->get("session_id");
        }
        else {
            $sessionIdKey = $this->app->make('session.store')->getId();
        }
        if (!$sessionIdKey && !$this->app->runningInConsole()) {
            throw new CustomException(ResponseMessages::SESSION_ID_REQUIRED, ResponseCodes::SESSION_ID_REQUIRED);
        }

        $this->session = new Session($sessionIdKey);
    }

    protected function setCoreSession()
    {
        $this->request->core_session = $this->session;
    }
}
