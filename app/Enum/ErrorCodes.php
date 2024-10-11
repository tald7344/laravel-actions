<?php

namespace App\Enum;

enum ErrorCodes: string
{
    case UNAUTHORISED = 'Unauthorised';
    case UNDEFINED_ERROR = 'undefined_error';
    case NOT_FOUND = 'not_found';
}
