<?php

namespace pizzashop\auth\api\Exception;

class InvalidTokenException extends \Exception
{
    public function __construct($message = "Invalid token", $code = 401)
    {
        parent::__construct($message, $code);
    }

}