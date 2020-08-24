<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *
 * @package App\Helpers
 * @author Adeniyi
 */
class ResponseHelper
{

    const STATUS_SUCCESS = "success";
    const STATUS_ERROR = "error";

    public static function createSuccessResponse(array $data, string $message = ""): Response
    {
        return self::createResponse(self::STATUS_SUCCESS, $data, $message);
    }

    public static function createResponse(
        string $status = self::STATUS_SUCCESS,
        array $data = [],
        string $message = "",
        int $code = 0,
        $httpResponseCode = 200
    ): Response {
        $responseData = [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
        if (!empty($code)) {
            $responseData['code'] = $code;
        }
        $token = JWTAuth::getToken();

        $header = [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE, PATCH',
            'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Origin, Authorization',
            'Bearer' => $token,
            'session' => \request()->core_session->sessionId
        ];
        return Response($responseData, $httpResponseCode, $header);
    }

    public static function createErrorResponse(
        $message,
        $errorCode,
        array $data = [],
        $httpResponseCode = 401
    ): Response {
        return self::createResponse(self::STATUS_ERROR, $data, $message, $errorCode, $httpResponseCode);
    }
}
