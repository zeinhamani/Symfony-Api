<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[AsController]
class UserController extends AbstractController
{
    #[Route(
        '/user', 
        name: 'user_post',
        path: "/users",
        methods: ["POST"],
        defaults : [  
            "_api_resource_class" => User::class,
            "_api_collection_operation_name"=> "post"
        ]


    )]
    public function postAction(User $data, UserPasswordEncoderInterface $encoder): User
    {
        return $this->encodePassword($data, $encoder);
    }

    #[Route(
        name: "user_put",
        path: "/users/{id}",
        requirements: ["id" =>"\d+"],
        methods: ["PUT"],
        defaults: [
            "_api_resource_class" => User::class,
            "_api_item_operation_name" => "put"
        ]
    )]
    public function putAction(User $data, UserPasswordEncoderInterface $encoder): User
    {
        return $this->encodePassword($data, $encoder);
    }

    protected function encodePassword(User $data, UserPasswordEncoderInterface $encoder): User
    {
        $encoded = $encoder->encodePassword($data, $data->getPassword());
        $data->setPassword($encoded);

        return $data;
    }

}
