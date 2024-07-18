<?php

namespace App\Exceptions;

use Exception;

class ViaCepZipNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Zip code not found');
    }
}
