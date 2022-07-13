<?php

namespace App\Tests\Unit\UserTest;

use App\Entity\Habitat;
use App\Entity\Reservation;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
   
    private User $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testGetEmail(): void {
        $value = 'test@test.com';

        $response = $this->user->setEmail($value);

        $getEmail = $this->user->getEmail();

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value,$this->user->getEmail());
        self::assertEquals($value,$this->user->getUsername());

    }
    public function testGetRoles(): void {
        $value1 = ['ROLE_ADMIN'];
        $value2 = ['ROLE_PROP'];
        $value3 = ['ROLE_LOC'];

        $response = $this->user->setRoles($value3);

        self::assertInstanceOf(User::class, $response);
        self::assertContains('ROLE_USER', $this->user->getRoles());
        self::assertContains('ROLE_LOC', $this->user->getRoles());
       

    }
    public function testGetPassword(): void {
        $value = 'zein';
        $response = $this->user->setPassword($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals('zein', $this->user->getPassword());
    }
    public function testGetHabitats(): void {
        $value = new Habitat();
        $response = $this->user->addHabitat($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(1, $this->user->getHabitats());
        self::assertTrue($this->user->getHabitats()->contains($value));

       $response = $this->user->removeHabitat($value);

       self::assertInstanceOf(User::class, $response);
        self::assertCount(0, $this->user->getHabitats());
        self::assertFalse($this->user->getHabitats()->contains($value));
    }

    public function testGetReservations(): void {
        $value = new Reservation();
        $response = $this->user->addReservation($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(1, $this->user->getReservations());
        self::assertTrue($this->user->getReservations()->contains($value));

        $response = $this->user->removeReservation($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(0, $this->user->getReservations());
        self::assertFalse($this->user->getReservations()->contains($value));
    }
}