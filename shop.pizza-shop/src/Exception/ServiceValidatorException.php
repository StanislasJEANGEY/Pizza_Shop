<?php

namespace pizzashop\shop\Exception;

use Exception;

class ServiceValidatorException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}