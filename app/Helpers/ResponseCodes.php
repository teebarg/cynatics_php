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
    const EXCEPTION_THROWN = 3;
    const RESOURCE_NOT_FOUND = 7;
    const FAILED_VALIDATION = 8;
    const RESOURCE_AUTHORISATION_ERROR = 9;
    const UNPROCESSABLE_ENTITY = 422;
    const UNAUTHENTICATED = 401;
}
