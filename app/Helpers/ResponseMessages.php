<?php

/**
 * @class: ResponseMessage
 * @namespace: App\Helpers
 *
 * @author: Adeniyi
 */

namespace App\Helpers;

class ResponseMessages
{

    const ACTION_SUCCESSFUL = "Requested action successful.";
    const UPLOAD_FAILED = 'Upload Failed';
    const EXCEPTION_THROWN = 'Ops, an error occurred, we are fixing it. Please try again later.';
    const RESOURCE_NOT_FOUND = "Requested resource could not be located";
    const FAILED_VALIDATION = "The given data failed to pass validation";
    const ROUTE_NOT_FOUND = "Route not found";
    const SESSION_ID_REQUIRED = 'Session Id is required.';

    const ITEM_NOT_IN_SLIP = 'Item is no longer in your slip.';
    const ERROR_MODIFYING_SLIP = 'There was an error adding or removing item from your slip. '
    . 'Please try again.';
    const USER_NOT_LOGGED_IN = 'You are not logged in. Please login or create an account to proceed.';


}
