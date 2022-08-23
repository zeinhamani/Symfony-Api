<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use ApiPlatform\Core\Validator\Exception\ValidationException;

class UploadMediaAction 
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

     /**
     * @var FormFactoryInterface
     */
    private $formFactory;

     /**
     * @var ValidatorInterface
     */
    private $validator;
    public function __construct(EntityManagerInterface $entityManager,
    FormFactoryInterface $formFactory,
    ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
    }
    public function __invoke(Request $request)
    {
        //create a new media instance
        $media = new Media();

        //validate the form
        $form = $this->formFactory->create(MediaType::class ,$media);
        $form->handleRequest($request);

        if($form->isSubmitted()){
              //Persist the new Media entity
              $this->entityManager->persist($media);
              $this->entityManager->flush();

              $media->setFile(null);
              return $media;
        }
       
        /*/Uploading done for us in background by VichUploade
        throw new ValidationException(
            $this->validator->validate($media)
        );*/
    }
}