<?php

namespace App\Exceptions;

use Exception;

class ViaCepInvalidZipException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid zip code');
    }
}
