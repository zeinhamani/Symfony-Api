<?php

namespace App\Tests\Func;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase {

    private array $serverInfos = ['ACCEPT'=>'application/ld+json','CONTENT_TYPE'=>'application/ld+json'];
    public function getResponseFromRequest(string $methode,string $uri, string $payload= ''): Response {

        $client = self::createClient();

        $client->request(
            $methode,
            $uri . '.json',
            [],
            [],
            $this->serverInfos,
            $payload
        );
        return $client->getResponse();
    }
}