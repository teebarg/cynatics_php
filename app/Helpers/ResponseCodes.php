<?php
/**
 * @class: ResponseCodes
 * @namespace: App\Helper
 *
 * @author: Adeniyi
 */

namespace App\Helpers;


class ResponseCodes
{
    const SESSION_ID_REQUIRED = 2;
    const EXCEPTION_THROWN = 3;
    const INVALID_PARAM = 5;
    const ROUTE_NOT_FOUND = 7;
    const FAILED_VALIDATION = 8;
    const RESOURCE_AUTHORISATION_ERROR = 9;
    const USER_NOT_LOGGED_IN = 102;
    const ERROR_MODIFYING_SLIP = 104;
    const ITEM_NOT_IN_SLIP = 112;
    const UNPROCESSABLE_ENTITY = 422;
    const UNAUTHENTICATED = 401;
    const UNAUTHORIZED = 403;
    const RESOURCE_NOT_FOUND = 404;
}
