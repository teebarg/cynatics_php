<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimAuthController extends BaseController
{
    public function login(Request $request, GoogleAuthenticationStub $gAuth, AdminAuthService $authService)
    {
        $token = $request->request->get('token', '');
        if (empty($token)) {
            return $this->sendError(ResponseMessages::INVALID_PARAM, ResponseCodes::INVALID_PARAM);
        }

        $admin = $gAuth->authenticate(['token' => $token]);
        if (empty($admin)) {
            $errors = ['errors' => $gAuth->getErrors()];
            return $this->sendError(
                ResponseMessages::AUTHENTICATION_FAILED,
                ResponseCodes::AUTHENTICATION_FAILED,
                $errors
            );
        }
        if ($authService->login($admin)) {
            return $this->sendSuccess(['admin' => $admin]);
        } else {
            return $this->sendError(
                ResponseMessages::LOGIN_FAIL,
                ResponseCodes::LOGIN_FAIL,
                ['errors' => $authService->getErrors()]
            );
        }
    }
}
