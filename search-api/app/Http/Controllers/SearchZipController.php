<?php

namespace App\Http\Controllers;

use App\Exceptions\ViaCepInvalidZipException;
use App\Exceptions\ViaCepRequestException;
use App\Exceptions\ViaCepZipNotFoundException;
use App\Services\ViaCepService;
use Exception;
use Illuminate\Http\JsonResponse;

class SearchZipController extends Controller
{

    private ViaCepService $viaCepService;

    public function __construct(ViaCepService $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $zip): JsonResponse
    {
      try {
        $data = $this->viaCepService->getAddressByZip(
          zip: $zip ?? ''
        );
        return response()->json($data);
      } catch (ViaCepZipNotFoundException | ViaCepInvalidZipException $e) {
          return response()->json(['error' => $e->getMessage()], 400);
      } catch (ViaCepRequestException | Exception $e) {
          return response()->json(['error' => $e->getMessage()], 500);
      }      
    }
}
