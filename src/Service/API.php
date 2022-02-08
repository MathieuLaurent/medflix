<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
 
class API{

    private $client;

    public function __construct(HttpClientInterface $client){
        $this->client = $client;
    }

    
}