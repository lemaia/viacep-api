<?php

namespace App\Exceptions;

use Exception;

class ViaCepRequestException extends Exception
{
    public function __construct()
    {
        parent::__construct('Error on request to ViaCep');
    }
}
