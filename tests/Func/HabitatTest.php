<?php

namespace App\Tests\Func;


use App\Tests\Func\AbstractEndPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class HabitatTest extends AbstractEndPoint {
   private string $habitatPayload = '
                          {"titre":"%s","adresse":"%s","presentation":"%s","prix":%f,"superficie":%d,
                            "capaciteAccueil":%d,"dateOuvertureAu":"2022-05-12", "dateOuvertureDu":"2022-05-12", "user":"api/users/2",
                            "destination": "api/destinations/2"}'; 
   public function testGethabitats(): void {

      
        $response = $this->getResponseFromRequest(Request::METHOD_GET,'/api/habitats');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
    public function testPosthabitat(): void {

      
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/habitats',
           $this->getPayload());
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);
    
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayload(): string {
       $fake = Factory::create();
       return sprintf($this->habitatPayload, 
       $fake->text(50),$fake->text(70),$fake->text(300),
       $fake->randomFloat(),$fake->randomNumber(),$fake->numberBetween(0, 20));
    }
}