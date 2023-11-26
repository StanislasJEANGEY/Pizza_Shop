<?php

namespace pizzashop\auth\api\Exception;

class ExpiredTokenException extends \Exception
{
    public function __construct($message = "Token expired", $code = 401)
    {
        parent::__construct($message, $code);
    }

}