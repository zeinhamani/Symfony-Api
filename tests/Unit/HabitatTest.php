<?php

namespace App\Tests\Unit\habitatTest;

use App\Entity\Categorie;
use App\Entity\Destination;
use App\Entity\Equipement;
use App\Entity\User;
use App\Entity\Habitat;
use App\Entity\Media;
use App\Entity\Reservation;
use App\Entity\Service;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\VarDumper\Cloner\Data;

class HabitatTest extends TestCase {
   
    private Habitat $habitat;
    protected function setUp(): void
    {
        parent::setUp();

        $this->habitat = new Habitat();
    }

    public function testGetTitre(): void {
        $value = 'Super Titre pour le test';

        $response = $this->habitat->setTitre($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getTitre());

    }
    public function testGetPresentation(): void {
        $value = 'Super Presentation pour le test, Super Presentation pour le test,Super Presentation pour le test';
        $response = $this->habitat->setPresentation($value);

        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getPresentation());
    }
    public function testAdresse(): void {
        $value = 'Adresse 49 rue Test';

        $response = $this->habitat->setAdresse($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getAdresse());
        
    }
    public function testPrix(): void {
        $value = 300;

        $response = $this->habitat->setPrix($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getPrix());
    }
    public function testSuperficie(): void {
        $value = 23;

        $response = $this->habitat->setSuperficie($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getSuperficie());
    }

    public function testGetCapaciteAccueil(): void {
        $value = 7;
        $response = $this->habitat->setCapaciteAccueil($value);

        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getCapaciteAccueil());
    }
    public function testGetDateOuvertureDu(): void {
        $value = new DateTime();

        $response = $this->habitat->setDateOuvertureDu($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getDateOuvertureDu());
    }
    public function testGetDateOuvertureAu(): void {
        $value = new DateTime();

        $response = $this->habitat->setDateOuvertureAu($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getDateOuvertureAu());
    }

    public function testGetFermetureExp(): void {
        $value = 'Super Fermeture exptionnel pour le test';

        $response = $this->habitat->setFermetureExp($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getFermetureExp());
    }

    public function testGetHeureArriveeDu(): void {
       $value = new DateTime();

        $response = $this->habitat->setHeureArriveeDu($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getHeureArriveeDu());
    }
    public function testGetHeureArriveeAu(): void {
        $value = new DateTime();

        $response = $this->habitat->setHeureArriveeAu($value);

   
        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getHeureArriveeAu());
    }
    public function testGetDepartDu(): void {
        $value = new DateTime();

        $response = $this->habitat->setHeureDepartDu($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getHeureDepartDu());
    }
    public function testGetHeureDepartAu(): void {
        $value = new DateTime();

        $response = $this->habitat->setHeureDepartAu($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertEquals($value,$this->habitat->getHeureDepartAu());
    }

    public function testGetCategorie(): void {
        $value = new Categorie();

        $response = $this->habitat->setCategorie($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertInstanceOf(Categorie::class, $this->habitat->getCategorie());
    }
    public function testGetUser(): void {
        $value = new User();

        $response = $this->habitat->setUser($value);

        self::assertInstanceOf(Habitat::class, $response);
        self::assertInstanceOf(User::class, $this->habitat->getUser($value));

    }
    public function testGetDestination(): void {
        $value = new Destination;
        $response = $this->habitat->setDestination($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertInstanceOf(Destination::class, $this->habitat->getDestination($value));
    }
    public function testGetServices(): void {
        $value = new Service();
        $response = $this->habitat->addService($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertCount(1, $this->habitat->getServices());
    }
    public function testGetEquipements(): void {
        $value = new Equipement();
        $response = $this->habitat->addEquipement($value);


        self::assertInstanceOf(habitat::class, $response);
        self::assertCount(1, $this->habitat->getEquipements($value));
    }
    public function testGetMedias(): void {
        $value = new Media();
        $response = $this->habitat->addMedia($value);

        self::assertInstanceOf(habitat::class, $response);
        self::assertCount(1, $this->habitat->getMedias($value));
    }
    public function testGetReservations(): void {
        $value = new Reservation();
        $response = $this->habitat->addReservation($value);

        self::assertInstanceOf(habitat::class, $response);
        self::assertCount(1, $this->habitat->getReservations());
    }
 

}