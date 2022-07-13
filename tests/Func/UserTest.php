<?php

namespace App\Tests\Func;


use App\Tests\Func\AbstractEndPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class UserTest extends AbstractEndPoint {
   private string $userPayload = '{"email":"%s", "nom":"%s","password":"pass"}'; 
   public function testGetUsers(): void {

      
        $response = $this->getResponseFromRequest(Request::METHOD_GET,'/api/users');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
    public function testPostUser(): void {

      
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
           $this->getPayload());
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayload(): string {
       $faker = Factory::create();
       return sprintf($this->userPayload, $faker->email,$faker->word());
    }
}