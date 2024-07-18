<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchZipControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSearchZipSuccess()
    {
        Http::fake([
          'https://viacep.com.br/*' => Http::response([], 200),
        ]);     
        $response = $this->get('api/search/local/01001000,17560-246');
        $response->assertStatus(200);
    }

    public function testSearchZipInvalid()
    {
        Http::fake([
            'https://viacep.com.br/*' => Http::response([], 400),
        ]);

        $response = $this->get('api/search/local/95010A10');
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid zip code']);
    }    

    public function testSearchZipNotFound()
    {
        Http::fake([
          'https://viacep.com.br/*' => Http::response([
            'erro' => true
          ], 200),
        ]);      

        $response = $this->get('api/search/local/99999999');
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Zip code not found']);
    }        

    public function testSearchZipRequestError()
    {
        Http::fake([
          'https://viacep.com.br/*' => Http::response([], 500),
        ]);      

        $response = $this->get('api/search/local/12345678');
        $response->assertStatus(500);
        $response->assertJson(['error' => 'Error on request to ViaCep']);

    }      
}