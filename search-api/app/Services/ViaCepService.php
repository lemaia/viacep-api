<?php

namespace App\Services;

use App\Exceptions\ViaCepInvalidZipException;
use App\Exceptions\ViaCepRequestException;
use App\Exceptions\ViaCepZipNotFoundException;
use Illuminate\Support\Facades\Http;

class ViaCepService
{
    const URL = 'https://viacep.com.br/ws/{zip}/json/';

    public function getAddressByZip(string $zip): array
    {
        $zips = explode(',', $zip);
        rsort($zips);

        $data = [];
        foreach ($zips as $zip) {
            $response = $this->getAddress(trim($zip));
            if ($response) {
                $data[] = $response;
            }
        }
        return $data;
    }

    private function getAddress(string $zip): array
    {
      $url = str_replace('{zip}', $zip, self::URL);
      $response = Http::get($url);
      
      $statusCode = $response->status();

      if($statusCode === 400) {
        throw new ViaCepInvalidZipException();
      }

      if($statusCode !== 200) {
        throw new ViaCepRequestException();
      }

      $data = $response->json();

      if($data['erro'] ?? false) {
        throw new ViaCepZipNotFoundException();
      }

      return $response->json();
    }
}
