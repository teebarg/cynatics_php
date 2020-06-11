<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\ResponseMessages;

class BaseController extends Controller
{

    /**
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function sendSuccess(array $data, $message = '')
    {
        return ResponseHelper::createSuccessResponse($data, $message);
    }

    /**
     * @param $message
     * @param $error_code
     * @param array $data
     * @param int $http_response_code
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $error_code, array $data = [], $http_response_code = 401)
    {
        return ResponseHelper::createErrorResponse($message, $error_code, $data, $http_response_code);
    }

}
