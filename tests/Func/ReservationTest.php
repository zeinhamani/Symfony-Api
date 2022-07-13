<?php

namespace App\Tests\Func;


use App\Tests\Func\AbstractEndPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class ReservationTest extends AbstractEndPoint {
   private string $reservationPayload = '
                          {"DateArrivee": "2022-03-15",
                            "DateDepart": "2022-03-18",
                            "NombrePersonnes": %d,
                            "MontantTotal": %f,
                            "DateReservation": "2022-03-13",
                            "Annulee": false,
                            "user": "api/users/3",
                            "habitat": "api/habitats/3"}'; 
   public function testGetreservations(): void {

      
        $response = $this->getResponseFromRequest(Request::METHOD_GET,'/api/reservations');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
    public function testPostreservation(): void {

      
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/reservations',
           $this->getPayload());
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayload(): string {
       $fake = Factory::create();
       return sprintf($this->reservationPayload,$fake->numberBetween(0, 20), $fake->randomFloat());
    }
}