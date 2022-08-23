<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class PasswordHashSubscriber implements EventSubscriberInterface
{

    /*
    *@var UserPasswordHasherInterface
    */
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['hashPassword',EventPriorities::PRE_WRITE]
        ];
    }

    public function hashPassword(ViewEvent $event1){

        $user = $event1->getControllerResult();

        if(!$user instanceof User ){
            return ;
        }
        //encode Password
        $user->setPassword(
            $this->encoder->hashPassword($user,$user->getPassword())
        );
    }
}

