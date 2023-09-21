<?php

namespace pizzashop\shop\domain\service;

use Exception;

class ServiceCommandeNotFoundException extends Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}